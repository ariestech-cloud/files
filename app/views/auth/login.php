   <div class="container">
       <div class="row justify-content-center">
          <div class="col-xl-10 col-lg-12 col-md-9">
              <div class="card shadow my-5">
                  <div class="card-body p-5">
                    
                        <h1 class="text-center h4 text-gray-900 mb-4 brand">Aries<span class="text-primary">Tech</span></h1>
<form method="post" action="<?=$this->base_url('Auth/login');?>">
    <div class="input-group has-validation">
    <label for="validationUsername" class="input-group-text" id="FormValidationUsername"><i class="fas fa-user"></i></label>
      <input type="text" class="form-control <?=Flasher::form_error('username');?>" id="validationUsername" aria-describedby="FormValidationUsername validationUsernameFeedback" name="username" value="<?=Flasher::form_value('username');?>">
      <div id="validationUsernameFeedback" class="invalid-feedback ms-5">
        <?=Flasher::form_message('username');?>
      </div>
    </div>

    <div class="input-group has-validation mt-2">
    <label for="validationPassword" class="input-group-text" id="FormValidationPassword"><i class="fas fa-key"></i></label>
      <input type="password" class="form-control <?=Flasher::form_error('password');?>" id="validationPassword" aria-describedby="FormValidationPassword validationPasswordFeedback" name="password" value="<?=Flasher::form_value('password');?>">
      <div id="validationPasswordFeedback" class="invalid-feedback ms-5">
                <?=Flasher::form_message('password');?>
      </div>
    </div>
  <div class="text-center mt-2">
    <button class="btn btn-primary" type="submit" style="width:100%;">Login</button>
  </div>
</form>
<hr>
                    
                  </div>
              </div>
          </div> 
       </div>
   </div> 