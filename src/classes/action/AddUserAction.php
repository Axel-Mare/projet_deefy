<?php

namespace iutnc\deefy\action;

class AddUserAction extends Action
{
    public function execute(): string
    {
        if ($this->http_method === 'GET') {
            return <<<HTML
                <form method="post" action="?action=add-user">
                    <label>Nom :</label>
                    <input type="text" name="nom" required>

                    <label>Email :</label>
                    <input type="email" name="email" required>

                    <label>Âge :</label>
                    <input type="number" name="age" min="0" required>

                    <button type="submit">Connexion</button>
                </form>
            HTML;
        }

        $nom = filter_var(trim($_POST['nom'] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);

        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);

        $age = filter_var($_POST['age'] ?? '', FILTER_VALIDATE_INT);

        return "Nom : $nom, Email : $email, Age : $age ans";
    }
}