<?php


class Topic extends Database
{

    //=======================
    /* Find all topics */
    //=======================
    public function find_all_topics()
    {
        //prepare
        $this->stmt = $this->pdo->prepare("SELECT * from topics");

        //execute
        $this->stmt->execute();
        return $this->stmt->fetchAll();
    }

    //========================
    //Find a topic by its name
    //========================
    public function findTopicByName($topicName)
    {
        //prepare SQL statement. Vars come from Database class
        $this->stmt = $this->pdo->prepare("SELECT * from topics WHERE name = :name");

        //execute statement
        $this->stmt->execute([
            ":name" => $topicName
        ]);

        return $this->stmt->fetch();
    }

    //========================
    //Find a topic by its id
    //========================
    public function find_topic_by_id($topic_id)
    {
        //prepare SQL statement. Vars come from Database class
        $this->stmt = $this->pdo->prepare("SELECT * from topics WHERE id = :id");

        //execute statement
        $this->stmt->execute([
            ":id" => $topic_id
        ]);

        return $this->stmt->fetch();
    }

    //=========================
    /* Find number of subcribers of a topic by id
    */
    //=========================
    public function find_subscriber_number_by_id($topic_id)
    {
        //prepate sql statement
        $this->stmt = $this->pdo->prepare("SELECT * FROM users_topics WHERE topic_ID = :topic_id");
        $this->stmt->execute([
            ":topic_id" => $topic_id
        ]);

        return $this->stmt->rowCount();
    }



    //==================
    //create a new topic
    //==================
    public function createTopic($name, $description, $creator_id)
    {

        //prepare SQL statement. Vars come from Database
        $this->stmt = $this->pdo->prepare("INSERT INTO topics (name, creator_id, description) VALUES(:name, :creator_id, :description)");

        //execute sql statement
        if ($this->stmt->execute([
            ":name" => $name,
            ":creator_id" => intval($creator_id),
            ":description" => $description
        ])) {
            //get the ID of the last inserted Row into the DB, which in this case is the topic ID
            $topic_id = $this->pdo->lastInsertId();

            // if () {
            //     return true;
            // } else {
            //     return false;
            // }
            return $this->subscribe($_SESSION["user_id"], $topic_id);
        } else {
            return false;
        }
    }

    //================================
    /* make a user subscribe to a topic
    */
    //================================
    public function subscribe($user_id, $topic_id)
    {
        if ($this->findOeSubscriptionsByUserId($user_id, $topic_id)) {
            return false;
        } else {
            $this->stmt = $this->pdo->prepare("INSERT INTO users_topics (user_id, topic_id) VALUES(:user_id, :topic_id)");
            if ($this->stmt->execute([
                ":user_id" => $user_id,
                ":topic_id" => $topic_id
            ])) {
                return true;
            } else {
                return false;
            }
        }
    }

    //============================================
    /*find all topics that a user is subscribed to
    1. find all topic IDs that the user is subscribed to from the users_topics table
    2. for each of these, find the respective topic info from the topics table
    */
    //============================================
    public function findAllSubscriptionsByUserId($user_id)
    {
        //prepare SQL statement
        $this->stmt = $this->pdo->prepare("SELECT * from users_topics WHERE user_id = :user_id");

        $this->stmt->execute([
            ":user_id" => $user_id
        ]);

        $subscription_IDs = $this->stmt->fetchAll();



        return array_map(function ($subscriptions) {
            //prepare sql statement
            $this->stmt = $this->pdo->prepare("SELECT * from topics WHERE id = :id");
            $this->stmt->execute([
                ":id" => $subscriptions->topic_id
            ]);
            return $this->stmt->fetch();
        }, $subscription_IDs);
    }

    //===============================
    //find one subscription of a user
    //===============================
    public function findOeSubscriptionsByUserId($user_id, $topic_id)
    {
        //prepare SQL statement
        $this->stmt = $this->pdo->prepare("SELECT * from users_topics WHERE user_id = :user_id AND topic_id = :topic_id");

        $this->stmt->execute([
            ":user_id" => $user_id,
            ":topic_id" => $topic_id
        ]);

        //return fetching results
        return $this->stmt->fetch();
    }

    public function find_topic_info($subscriptions)
    {
        //prepare sql statement
        $this->stmt = $this->pdo->prepare("SELECT * from topics WHERE id = :id");
        $this->stmt->execute([
            ":id" => $subscriptions->topic_id
        ]);
        return $this->stmt->fetch();
    }
}