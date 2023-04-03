<?php include $data["header"]; ?>

<main class="container mt-0 text-center">
    <img src="<?php echo $data["image"]; ?>" class="img-fluid">
    <section class="w-50 mx-auto">      
        <h1 style="color: #1b2f34; font-weight: 900"><?php echo $data["info"]; ?></h1>
        <a href="<?php echo $data["url"]; ?>" class="btn btn-primary mt-3"><?php echo $data["btnText"]; ?></a>
    </section> 
</main>  

<?php include $data["footer"]; ?>




