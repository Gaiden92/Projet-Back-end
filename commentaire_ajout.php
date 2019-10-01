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

function getUrl(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];
    $annonceId= $_POST['annonce_id'];
    $membreId= $_POST['membre_id'];
    

    if ($mode == 'save-comment') {
        $profil = getMember();
//        if (!isset($profil)) {
//            header("Location: /samy/connexion.php?from=ajout_comment&annonce_id=$annonceId&membre_id=$membreId");
//        } else {
            $type = $_POST['type'];
            if ($type == 'note') {
                $note = NoteUtils::createNote($_POST);
                $saveNote = NoteDao::saveNote($pdo, $note);
                if ($saveNote) {
                    $messages = recupererAlerteMessages();
                    alertMessage('success', 'Votre note a été enregistrer!');
                    session_commit();
                    header("location:index.php");
                } else {
                    $errors = recupererAlerteMessages();
                }
            } else if ($type == 'comment') {
                $comment = CommentUtils::createComment($_POST);
                $saveComment = CommentDao::saveComment($pdo, $comment);
                if ($saveComment) {
                    $messages = recupererAlerteMessages();
//                    window . alert($messages["flash"]["success"]);
                    header("Location: index.php");
                } else {
                    $errors = recupererAlerteMessages();
                }
            }
//        }

    }
} else {
    $varIdGet = $_GET['id'];
    if (isset($varIdGet) && is_numeric($varIdGet)) {
        $annonceId = $varIdGet;
        $annonce = AnnonceDao::retrieveAnnonceById($pdo, $annonceId);
        $membre = MembreDao::retrieveMembreByAnnonceId($pdo, $annonceId);
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
                    echo("<span>Message d'erreur : $message</span><br>");
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
        }
        ?>
    </div>

    <script type="text/javascript">
        function showDiv(select) {
            if (select.value == "note") {
                document.getElementById('div_comment').style.display = "none";
                document.getElementById('div_note').style.display = "block";
            } else {
                document.getElementById('div_comment').style.display = "block";
                document.getElementById('div_note').style.display = "none";
            }
        }
    </script>

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

<?php

include __DIR__ . '/assets/includes/footer.php';