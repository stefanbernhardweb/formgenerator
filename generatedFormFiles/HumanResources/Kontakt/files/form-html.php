<?php 
            require('form-php.php');
        ?>
        <div class='container'>
                            <form method='POST'>  
                                <div class="form-group mt-3">
                                    <label for="textfield2" class="form-label">Ihr Name</label> <span class="required text-danger">*</span>
                                    <input type="text" class="form-control" id="textfield2" name="textfield2" placeholder="" required="required">
                                </div>             
                              
                                <div class="form-group mt-3">
                                    <label for="emailfield3" class="form-label">Ihre E-Mail</label> <span class="required text-danger">*</span>
                                    <input type="email" class="form-control" id="emailfield3" name="emailfield3" placeholder="" required="required">
                                </div>             
                              
                                <div class="form-group mt-3">
                                    <label for="textarea4" class="form-label">Ihre Nachricht</label> <span class="required text-danger">*</span>
                                    <textarea name="textarea4" id="textarea4" placeholder="" class="form-control" rows="4" required="required"></textarea>
                                </div>             
                              
                        <div class="form-group mt-3">
                            <input type="submit" class="form-control btn btn-light fw-bold" name="submit" value="Jetzt senden">
                        </div>             
                    </form>
                            <?php echo $error ?? $success; ?>
                        </div>