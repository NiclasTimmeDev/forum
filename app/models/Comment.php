<?php


class Comment extends Database
{
    //=============================
    /*
    Create Comment
    */

    //=============================
    public function create_comment($thread_id, $creator_id, $text, $user_name)
    {
        $this->stmt = $this->pdo->prepare("INSERT INTO comments (thread_id, creator_id, text, user_name) VALUES(:thread_id, :creator_id, :text, :user_name)");

        if ($this->stmt->execute(array(
            ":thread_id" => $thread_id,
            ":creator_id" => $creator_id,
            ":text" => $text,
            ":user_name" => $user_name
        ))) {
            return true;
        } else {
            return false;
        }
    }

    public
    function get_all_comments_by_thread_id($thread_id)
    {
        //prepare
        $this->stmt = $this->pdo->prepare("SELECT * from comments WHERE thread_id = :thread_id");

        //execute
        $this->stmt->execute(array(
            ":thread_id" => $thread_id
        ));

        return $this->stmt->fetchAll();


    }
}