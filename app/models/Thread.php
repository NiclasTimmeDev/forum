<?php

class Thread extends Database
{

    //==================================
    /*Check if a thread in a specific topic already exists */
    //==================================
    public function findThreadNameByTopicId($thread_name, $topic_id)
    {
        //prepare
        $this->stmt = $this->pdo->prepare("SELECT * from threads WHERE topic_id = :topic_id AND name = :thread_name");

        //execute
        $this->stmt->execute(array(
            ":topic_id" => $topic_id,
            ":thread_name" => $thread_name
        ));

        return $this->stmt->fetch();
    }

    //============================
    /* Create a new thread
    */
    //============================
    public function create_thread($name, $description, $topic_id, $creator_id)
    {
        //prepare statement
        $this->stmt = $this->pdo->prepare("INSERT INTO threads (topic_id, name, description, creator_id) VALUES(:topic_id, :name, :description, :creator_id) ");
        //execute
        try {
            if ($this->stmt->execute(array(
                ":topic_id" => $topic_id,
                ":name" => $name,
                ":description" => $description,
                ":creator_id" => $creator_id
            ))) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //==================================
    /* Get all Threads of a topic by topic id */
    //==================================
    public function get_threads_by_topic_id($topic_id)
    {
        //prepare sql satement
        $this->stmt = $this->pdo->prepare("SELECT * FROM threads where topic_id = :topic_id");

        //execute sql statement
        $this->stmt->execute(array(
            ":topic_id" => $topic_id
        ));

        return $this->stmt->fetchAll();
    }
    //==================================
    /* Get one Threads of a topic by topic id and thread id*/
    //==================================
    public function get_thread_by_topic_id_and_thread_id($topic_id, $thread_id)
    {
        //prepare sql satement
        $this->stmt = $this->pdo->prepare("SELECT * FROM threads where topic_id = :topic_id and id = :id");

        //execute sql statement
        $this->stmt->execute(array(
            ":topic_id" => $topic_id,
            ":id" => $thread_id
        ));

        return $this->stmt->fetch();
    }
}