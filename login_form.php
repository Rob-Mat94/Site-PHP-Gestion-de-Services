<?php
$title="Authentification";
include("header.php");

echo "<p class=\"error\">".($error??"")."</p>";
?>
<section id="login">
    <div class='center'>
        <h2 id="Titreform">Gestion des services :</h2>

                    <form method="post" id="fromlog">
                        <fieldset>
                            <legend>Authentifiez-vous</legend>
                            <table class="center">
                            <tr>
                            <td><label for="inputNom" class="control-label">Login</label></td>
                            <td><input type="text" name="login" size="20" class="form-control" id="inputLogin" required placeholder="login"
                                   required value="<?= $data['login']??"" ?>"></td>
                            </tr>
                            <tr>
                            <td><label for="inputMDP" class="control-label">Password</label></td>
                            <td><input type="password" name="password" size="20" class="form-control" required id="inputMDP"
                                   placeholder="Mot de passe"></td>
                            </tr>
                            </table>
                         </fieldset>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="button">Connexion</button>
                        </div>

                    </form>
    </div>
</section>
<?php

include("footer.php");

/*
    <span class="pull-right"><a href="<?= $pathFor['adduser'] ?>">S'enregistrer</a></span>
*/