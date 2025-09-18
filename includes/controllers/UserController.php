<?php
class UserController
{
    public static function deleteAccount(PDO $pdo, int $userId): bool
    {
        $pdo->beginTransaction();
        try {
            // If you don’t have FK CASCADEs, remove dependents explicitly:
            $pdo->prepare('DELETE FROM usersocials WHERE UserID = ?')->execute([$userId]);
            $pdo->prepare('DELETE FROM profile     WHERE ProfileID = ?')->execute([$userId]);
            // Finally delete the user
            $ok = $pdo->prepare('DELETE FROM users WHERE UserID = ?')->execute([$userId]);

            $pdo->commit();
            return $ok;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            return false;
        }
    }
}