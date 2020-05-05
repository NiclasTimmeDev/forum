<?php


class Topic extends Database
{
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
    //find all topics that a user is subscribed to
    //============================================
    public function findAllSubscriptionsByUserId($user_id)
    {
        //prepare SQL statement
        $this->stmt = $this->pdo->prepare("SELECT * from users_topics WHERE user_id = :user_id");

        $this->stmt->execute([
            ":user_id" => $user_id
        ]);

        //return fetching results
        return $this->stmt->fetchAll();
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
}