<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';
require_once __DIR__ . '/assets/dao/MembreDao.php';
require_once __DIR__ . '/assets/dao/AnnonceDao.php';
require_once __DIR__ . '/assets/dao/NoteDao.php';
require_once __DIR__ . '/assets/dao/CommentDao.php';

require_once __DIR__ . '/assets/utils/NoteUtils.php';
require_once __DIR__ . '/assets/utils/CommentUtils.php';

$page_title = 'Note';

include __DIR__ . '/assets/includes/header.php';

function redirectToPage($page): void
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $annonce_id = isset($_POST['annonce_id']) ? $_POST['annonce_id']:null ;
        $membre_id = isset($_POST['membre_id']) ? $_POST['membre_id'] :null ;;
        $type = isset($_POST['type']) ? $_POST['type'] :null ;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $annonce_id = isset($_GET['annonce_id']) ? $_GET['annonce_id']:null ;
        $membre_id = isset($_GET['membre_id']) ? $_GET['membre_id'] :null ;
        $type = isset($_GET['type']) ? $_GET['type'] :null ;
    }

    if ($annonce_id && $membre_id) {
        session_commit();
        header("location: {$page}?current_page=ajout_$type&annonce_id=$annonce_id&membre_id=$membre_id");
    }

}
if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];
    $annonceId = $_POST['annonce_id'];
    $membreId = $_POST['membre_id'];

    if ($mode == 'save-comment') {
        $type = $_POST['type'];
        if ($type == 'note') {
            $note = NoteUtils::createNote($_POST);
            $saveNote = NoteDao::saveNote($pdo, $note);
            if ($saveNote) {
                $messages = recupererAlerteMessages();
                alertMessage('success', 'Votre note a bien été enregistré !');
                redirectToPage("index.php");
            } else {
                $errors = recupererAlerteMessages();
            }
        } else if ($type == 'comment') {
            $profil = getMember();
            if (!isset($profil)) {
                redirectToPage("connexion.php");
            } else {
                $comment = CommentUtils::createComment($_POST);
                echo ("2- BEFORE SAVE : Annonce id:". $_POST['annonce_id']." vs annonceId = " .$annonceId."<br>");
                echo ("2- AFTER SAVE  : Annonce id:". $comment['annonce_id']." vs annonceId = " .$annonceId."<br>");
                $saveComment = CommentDao::saveComment($pdo, $comment);
                echo ("2- AFTER SAVE  : Annonce id:". $comment['annonce_id']." vs annonceId = " .$annonceId."<br>");
            if ($saveComment) {
                $messages = recupererAlerteMessages();
                alertMessage('success', 'Votre commentaire a bien été enregistré!');
                redirectToPage("index.php");
            } else {
                $errors = recupererAlerteMessages();
            }
            }
        }
    }
    $annonce = AnnonceDao::retrieveAnnonceById($pdo, $annonceId);
    $membre = MembreDao::retrieveMembreByAnnonceId($pdo, $annonceId);
    echo ("5- AFTER ALL : Annonce id:".$annonce['id_annonce']." vs annonceId = " .$annonceId."<br>");

} else {
    $varIdGet = isset($_GET['id']) ? $_GET['id'] : null;
    if (isset($varIdGet) && is_numeric($varIdGet)) {
        $annonceId = $varIdGet;
        $annonce = AnnonceDao::retrieveAnnonceById($pdo, $annonceId);
        $membre = MembreDao::retrieveMembreByAnnonceId($pdo, $annonceId);
		echo ("0- AFTER SELECT : Annonce id:".$annonce['id_annonce']." vs annonceId = " .$annonceId."<br>");
    } else {
        redirectToPage("index.php");
    }
}
?>

    <div class="container border mt-4 p-4">
        <?php
        if (isset($messages) && count($messages) > 0) {
            ?>
            <div class="alert alert-success">
                <?php
                foreach ($messages as $message) {
                    if (is_array($message)) {
                        foreach ($message as $mes) {
                            echo("<span>$mes</span><br>");
                        }
                    } else {
                        echo("<span>Message : $message</span><br>");
                    }
                }
                ?>
            </div>
            <?php
        }
        if (isset($errors) && count($errors) > 0) {
            ?>
            <div class="alert alert-error">
                <?php
                foreach ($errors as $error) {
                    if (is_array($error)) {
                        foreach ($error as $err) {
                            echo("<span>Message d'erreur : $err</span><br>");
                        }
                    } else {
                        echo("<span>Message d'erreur : $error</span><br>");
                    }
                }
                ?>
            </div>
            <?php 
if (isset($comment) && isset($comment['annonce_id'])) {
			echo ("3- AVANT AFFICHAGE FORM : Annonce id:".$comment['annonce_id']." vs annonceId : ".$annonceId."<br>");
}else {
			echo ("3- AVANT AFFICHAGE FORM (JUSTE ANNONCE ID) : annonceId : ".$annonceId."<br>");
}
        }
        ?>
    </div>
    
    <script type="text/javascript">
        function showDiv(select) {
            if (select.value === "note") {
                document.getElementById('div_comment').style.display = "none";
                document.getElementById('div_note').style.display = "block";
            } else {
                document.getElementById('div_comment').style.display = "block";
                document.getElementById('div_note').style.display = "none";
            }
        }
    </script>

<?php
if (isset($membre) && isset($membre["id_membre"])) {
    ?>
    <div class="container border mt-4 p-4">
        <select name="type" onchange="showDiv(this)">
            <option class="form-control" value="">choix du type</option>
            <option selected="selected" class="form-control" value="comment">Commentaire</option>
            <option class="form-control" value="note">Note</option>
        </select>

        <div id="div_comment" style="display:block;">
            <h1>Ajouter un commentaire au membre '<?= $membre['prenom']; ?> <?= $membre['nom']; ?>'</h1>

            <form action="commentaire_ajout.php" method="post">
                <div class="form-group">
                    <label>Commentaire</label>
                    <input type="text" name="comment" class="form-control" value="">
                </div>


                <input hidden="hidden" type="text" name="type" value="comment"/>
                <input hidden="hidden" type="text" name="annonce_id" value="<?= $annonceId ?>"/>
                <input hidden="hidden" type="text" name="membre_id" value="<?= $membre['id_membre'] ?>"/>
                <input hidden="hidden" type="text" name="mode" value="save-comment"/>
                <input type="submit" name="save-comment" value="Enregistrer" class="btn btn-lg btn-success">
            </form>
        </div>

        <div id="div_note" style="display:none;">
            <h1>Ajouter une note au membre '<?= $membre['prenom']; ?> <?= $membre['nom']; ?>'</h1>

            <form action="commentaire_ajout.php" method="post">
                <div class="form-group">
                    <label>Note</label>
                    <select name="note">
                        <option class="form-control" value="1">*</option>
                        <option class="form-control" value="2">**</option>
                        <option class="form-control" value="3">***</option>
                        <option class="form-control" value="4">****</option>
                        <option class="form-control" value="5">*****</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Avis</label>
                    <input type="text" name="avis" class="form-control" value="">
                </div>

                <input hidden="hidden" type="text" name="type" value="note"/>
                <input hidden="hidden" type="text" name="annonce_id" value="<?= $annonceId ?>"/>
                <input hidden="hidden" type="text" name="membre_id" value="<?= $membre['id_membre'] ?>"/>
                <input hidden="hidden" type="text" name="mode" value="save-comment"/>
                <input type="submit" name="save-comment" value="Enregistrer" class="btn btn-lg btn-success">
            </form>
        </div>
    </div>

    <?php echo ("2- AFTER DISPLAY FORM : Annonce id:".$annonceId. "<br>");
} else {
    ?>
    <h3>Problème de redirection. Cette doit s'afficher après avoir cliqué sur une annonce !</h3>
    <?php
}
?>

<?php

include __DIR__ . '/assets/includes/footer.php';