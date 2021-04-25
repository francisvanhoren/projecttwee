<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Controleer of het contact-ID bestaat
if (isset($_GET['id'])) {
    // Selecteer het record dat zal worden verwijderd
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact bestaat niet met dat ID!');
    }
    // Zorg ervoor dat de gebruiker dit bevestigt voordat het wordt verwijderd
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Gebruiker klikte op de knop "Ja", record verwijderen
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'U heeft het contact verwijderd!';
            header('Location: read.php');
        } else {
            // De gebruiker klikte op de knop "Nee" en stuurde ze terug naar de gelezen pagina
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
    <h2>Verwijder Contact <?=$contact['name']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Ben je zeker dat je het contact <?=$contact['name']?> wil verwijderen ?</p>
        <div class="yesno">
            <a href="delete.php?id=<?=$contact['id']?>&confirm=yes">ja</a>
            <a href="delete.php?id=<?=$contact['id']?>&confirm=no">nee</a>
        </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
