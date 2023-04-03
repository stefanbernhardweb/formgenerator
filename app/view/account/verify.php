<?php include "app/view/includes/header.php"; ?>
<main class="container mt-5">
    <h1 class="text-center mb-5">Verifizierung deines Accounts</h1>
    <section class="w-50 mx-auto">      
        
        <?php echo $data["error"] ?? $data["success"]; ?>
    </section> 
</main>  

<?php include "app/view/includes/footer.php"; ?>