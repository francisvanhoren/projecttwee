<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check dat Post data niet leeg is
if (!empty($_POST)) {
    // Post data is niet leeg voeg dan een nieuw record toe
    // Set-up de variables die gaan worden ingevoegd, nagaan dat de POST variables bestaan anders default naar blanco
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Controleer of POST-variabele "naam" bestaat, zo niet, dan is de standaardwaarde blanco, in principe hetzelfde voor alle variabelen
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    // Voeg een nieuw record in de contactenlijst in
    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $email, $phone, $title, $created]);
    // Uitvoerbericht
    $msg = 'Uw boodschap is verstuurd!';
}
?>
<?=template_header('Create')?>
<div class="container mt-4">
    <div class="row">

        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-4">
            <h4>Sophie Peeters</h4>
            <h6>Psychotherapeut / Klinisch psycholoog</h6>
            <hr>
            <p>+32(0) 470 97 22 58</p>
            <p>info@sophiepeeters.be</p>
            <p>Diestersteenweg</p>
            <p>3293 Kaggevinne</p>


        </div>
        <div class=" col-lg-6 col-md-12 col-sm-12 col-xs-12 ">
            <div class="map-responsive">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2511.9627217585107!2d5.033068315343408!3d50.97987965695663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c140a9ca7af917%3A0xbf99aa75be8358b5!2sDiestersteenweg%2087%2C%203293%20Diest!5e0!3m2!1snl!2sbe!4v1615963537521!5m2!1snl!2sbe" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

            </div>
        </div>

<div class="content update">
    <h2>Neem contact op met mij</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="name">Naam</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="name" placeholder="" id="name">
        <label for="email">Email</label>
        <label for="phone">tel</label>
        <input type="text" name="email" placeholder=" " id="email">
        <input type="text" name="phone" placeholder=" " id="phone">
        <label for="title">Vraag</label>
        <label for="created">Datum</label>
        <input type="text" name="title" placeholder=" " id="title">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <input type="submit" value="Verstuur">
    </form>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
