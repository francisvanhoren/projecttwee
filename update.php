<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Controleer of het contact-ID bestaat, bijvoorbeeld update.php? Id = 1 krijgt het contact met het ID van 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // Dit deel is vergelijkbaar met het bestand create.php, maar in plaats daarvan werken we een record bij en niet invoegen
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        // Werk het record bij
        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
        $stmt->execute([$id, $name, $email, $phone, $title, $created, $_GET['id']]);
        $msg = 'succesvol geupdatet!';
        header('Location: read.php');
    }
    // Haal het contact uit de contactenlijst
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact bestaat niet met dat ID!');
    }
} else {
    exit('Geen ID opgegeven!');
}
?>
<?=template_header('Read')?>

<div class="content update">
    <h2>Update Contact "<?=$contact['name']?>"</h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Naam</label>
        <input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id">
        <input type="text" name="name" placeholder="John Doe" value="<?=$contact['name']?>" id="name">
        <label for="email">Email</label>
        <label for="phone">Tel</label>
        <input type="text" name="email" placeholder=" " value="<?=$contact['email']?>" id="email">
        <input type="text" name="phone" placeholder=" " value="<?=$contact['phone']?>" id="phone">
        <label for="title">Tekst</label>
        <label for="created">Datum</label>
        <input type="text" name="title" placeholder=" " value="<?=$contact['title']?>" id="title">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
