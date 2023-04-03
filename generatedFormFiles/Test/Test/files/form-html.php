<?php 
            require('form-php.php');
        ?>
        <div class='container'>
                            <form method='POST'>  
                                <div class="form-group mt-3">
                                    <label for="textfield2" class="form-label">Text</label> <span class="required text-danger">*</span>
                                    <input type="text" class="form-control" id="textfield2" name="textfield2" placeholder="Example Text" required="required">
                                </div>             
                              
                        <div class="form-group mt-3">
                            <input type="submit" class="form-control btn btn-light fw-bold" name="submit" value="Jetzt senden">
                        </div>             
                    </form>
                            <?php echo $error ?? $success; ?>
                        </div>