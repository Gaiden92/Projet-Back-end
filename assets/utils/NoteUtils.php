<?php

class NoteUtils {

    public static function createNote()
    {
        $note=array();
        $note['membre_id1']=$_POST['membre_id'];
        $note['membre_id2']=$_POST['membre_id'];
        $note['note']=$_POST["note"];
        $note['avis']=$_POST["avis"];

        return $note;

    }
}

?>