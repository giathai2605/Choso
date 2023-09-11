<div class="page-intro top-content" id="user">
   <h2 class="page-title">User</h2>
   <p>In Affiliate, the user is the one who is allowed to access and manage the Affiliate records. These users can be defined under various track sales, clicks, and so many actions.</p>
   <p> User module in included all user activity related it's personal information data</p>
   <p>here user can add it's unique profile, update, delete, login, change password and get details</p>
</div>

<!-- start get Registration from -->
<div class="top-content" id="registration-form-details">
   <h3 class="page-title">Registration Form</h3>
   <p>The registration form can be structured dynamically by the admin at any time from settings. you can access that form's custom field from provided API.</p>
</div>
<div class="row">
   <div class="col-md-6">
      <div class="panel white">
         <div class="panel-heading">
            <h3 class="panel-title">Request :  </h3><br>
            <p><span class="text-success">GET</span> : <?=base_url();?>user/get_registration_form</p>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <!-- TABLE HOVER -->
      <div class="panel black">
         <div class="panel-heading">
            <h3 class="panel-title">Response</h3>
         </div>
         <div class="panel-body">
            <pre class="response-view">{ "status": true, "data": [ { "type": "header", "label": "Firstname" }, { "type": "header", "label": "Lastname" }, { "type": "header", "label": "Email" }, { "type": "text", "label": "Mobile Phone", "placeholder": "Enter your mobile number", "className": "form-control", "name": "text-1621449816785", "mobile_validation": "true", "hide_on_registration": "true" }, { "type": "header", "label": "Username" }, { "type": "header", "label": "Password" }, { "type": "header", "label": "Confirm_password" }, { "type": "textarea", "required": "true", "label": "Text Area", "placeholder": "Your message", "className": "form-control", "name": "textarea-1623347397482" } ] }</pre>
         </div>
      </div>
   </div>
</div>
<!-- end Get Registration from -->


<div class="top-content" id="registration">
   <h3 class="page-title">Registration</h3>
   <p>Create new user with HTTP POST request.</br>During the creation you can set up all attributes describe in below</br>If given email and username doesn't exists it will be created</p>
</div>
<div class="row">
   <div class="col-md-6">
      <div class="panel white">
         <div class="panel-heading">
            <h3 class="panel-title">Request :  </h3>
         </br>
         <span class="text-warning">POST</span> : <?=base_url();?>User/registarion</p>
      </div>
      <div class="panel-body">
         <table class="table table-hover">
            <thead>
               <tr>
                  <th>Parameter</th>
                  <th>Type</th>
                  <th>Required</th>
                  <th>Description</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>firstname</td>
                  <td><code>string</code></td>
                  <td><code>true</code></td>
                  <td>-</td>
               </tr>
               <tr>
                  <td>lastname</td>
                  <td><code>string</code></td>
                  <td><code>true</code></td>
                  <td>-</td>
               </tr>
               <tr>
                  <td>username</td>
                  <td><code>string</code> <code>number</code></td>
                  <td><code>true</code></td>
                  <td>your unique username</td>
               </tr>
               <tr>
                  <td>email</td>
                  <td><code>string</code></td>
                  <td><code>true</code></td>
                  <td>-</td>
               </tr>
               <tr>
                  <td>password</td>
                  <td><code>string</code> <code>number</code> <code>special character</code></td>
                  <td><code>true</code></td>
                  <td>-</td>
               </tr>
               <tr>
                  <td>cpassword</td>
                  <td><code>string</code> <code>number</code> <code>special character</code></td>
                  <td><code>true</code></td>
                  <td>password confirmation</td>
               </tr>
               <tr>
                  <td>device_type</td>
                  <td><code>number</code></td>
                  <td><code>true</code></td>
                  <td>(1 = android, 2 = ios)</td>
               </tr>
               <tr>
                  <td>device_token</td>
                  <td><code>string</code></td>
                  <td><code>true</code></td>
                  <td>-</td>
               </tr>

               <?php foreach ($registration_fields as $field) {
                  if($field['type'] != 'header' && !$field['hide_on_registration']) {
                     ?>
                     <tr>
                        <td>custom_<?= $field['name']; ?></td>
                        <td><code><?= ($field['mobile_validation']) ? 'Mobile Number' : $field['type']; ?></code></td>
                        <td><code><?= ($field['required']) ? 'true' : 'false'; ?></code></td>
                        <td><?= str_replace('Enter ', '', $field['placeholder']); ?></td>
                     </tr>
                     <?php
                  }
               } ?>

               <tr>
                  <td>terms</td>
                  <td><code>boolean</code></td>
                  <td><code>true</code></td>
                  <td>You must accept terms and conditions.</td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</div>
<div class="col-md-6">
   <!-- TABLE HOVER -->
   <div class="panel black">
      <div class="panel-heading">
         <h3 class="panel-title">Response</h3>
      </div>
      <div class="panel-body">
         <pre class="response-view">{"status":true,"message":"user registration successfully"}</pre>
      </div>
   </div>
</div>
</div>

<!-- start login -->
<div class="top-content" id="login">
   <h3 class="page-title">Login</h3>
   <p>
      Login user with HTTP POST request.
   </p>
   <p>
      you can access all your affiliate system using your credentials. required to enter your username and password
   </p>
   <p>
   Authentication token are required as an authentication method with Affiliate apis. By using an Authentication token you authenticate access to the specific API. Without authentication access to the API is denied.</br>
   login api will generate a unique your user token for API authentication.
</p>
</div>
<div class="row">
   <div class="col-md-6">
      <div class="panel white">
         <div class="panel-heading">
            <h3 class="panel-title">Request :  </h3>
         </br>
         <span class="text-warning">POST</span> : <?=base_url();?>User/login</p>
      </div>
      <div class="panel-body">
         <table class="table table-hover">
            <thead>
               <tr>
                  <th>Parameter</th>
                  <th>Type</th>
                  <th>Position</th>
                  <th>Description</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>username</td>
                  <td><code>string</code> <code>number</code></td>
                  <td><code>Body</code></td>
                  <td>you can add your unique username</td>
               </tr>
               <tr>
                  <td>password</td>
                  <td><code>string</code> <code>number</code> <code>special character</code></td>
                  <td><code>Body</code></td>
                  <td>-</td>
               </tr>
               <tr>
                  <td>device_type</td>
                  <td><code>number</code></td>
                  <td><code>Body</code></td>
                  <td>(1 = android, 2 = ios)</td>
               </tr>
               <tr>
                  <td>device_token</td>
                  <td><code>string</code></td>
                  <td><code>Body</code></td>
                  <td>-</td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</div>
<div class="col-md-6">
   <!-- TABLE HOVER -->
   <div class="panel black">
      <div class="panel-heading">
         <h3 class="panel-title">Response</h3>
      </div>
      <div class="panel-body">
         <pre class="response-view">{"status":true,"message":"user login successfully","data":{"token":"raNdom-UniQe-toKEn-wilL-be-HeRe","user_status":"membership-status-refunded","firstname":"aff1000","lastname":"aff1000","email":"user1@gmail.com","is_vendor":"0","profile_avatar":"http:\/\/localhost.add.com\/aff\/7-0-0-0\/assets\/vertical\/assets\/images\/no-image.jpg"}}</pre>
      </div>
   </div>
</div>
</div>
<!-- end login -->



<!-- start change password -->
<div class="top-content" id="change_password">
   <h3 class="page-title">Change Password</h3>
   <p>
      Change password with HTTP POST request.
   </p>
   <p>
      API token is required for the authentication of the calling program to the API.
   </p>
   <p>
      if you want to change your pass to enter old password and after add your new password and also enter confirm password.
   </p>
</div>
<div class="row">
   <div class="col-md-6">
      <div class="panel white">
         <div class="panel-heading">
            <h3 class="panel-title">Request :  </h3>
            <br>
            <span class="text-warning">POST</span> : <?=base_url();?>User/change_password</p>
         </div>
         <div class="panel-body">
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th>Parameter</th>
                     <th>Type</th>
                     <th>Position</th>
                     <th>Description</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>old_pass</td>
                     <td><code>string</code></td>
                     <td><code>Body</code></td>
                     <td>-</td>
                  </tr>
                  <tr>
                     <td>password</td>
                     <td><code>string</code></td>
                     <td><code>Body</code></td>
                     <td>-</td>
                  </tr>
                  <tr>
                     <td>conf_password</td>
                     <td><code>string</code></td>
                     <td><code>Body</code></td>
                     <td>-</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="panel black">
         <div class="panel-heading">
            <h3 class="panel-title">Response</h3>
         </div>
         <div class="panel-body">
            <pre class="response-view">{ "status": true, "message": "password change successfully" }</pre>
         </div>
      </div>
   </div>
</div>
<!-- end change password -->


<!-- start my profile details -->
<div class="top-content" id="get_my_profile_details">
   <h3 class="page-title">My Profile Details</h3>
   <p>My profile details with HTTP POST request.</p>
   <p>API token is required for the authentication of the calling program to the API.</p>
   <p>there is no need any parameter. we are get your data using your verify token</p>
</div>
<div class="row">
   <div class="col-md-6">
      <!-- TABLE HOVER -->
      <div class="panel white">
         <div class="panel-heading">
            <h3 class="panel-title">Request :  </h3><br>
            <span class="text-success">GET</span> : <?=base_url();?>User/get_my_profile_details</p>
         </div>
         <div class="panel-body">
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th>Parameter</th>
                     <th>Type</th>
                     <th>Position</th>
                     <th>Description</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>Authorization</td>
                     <td><code>string</code></td>
                     <td><code>Header</code></td>
                     <td>compolsory pass this authentication token in your header also get from login api</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <!-- END TABLE HOVER -->
   </div>
   <div class="col-md-6">
      <!-- TABLE HOVER -->
      <div class="panel black">
         <div class="panel-heading">
            <h3 class="panel-title">Response</h3>
         </div>
         <div class="panel-body">
            <pre class="response-view">{"status":true,"message":"user details get successfully","data":{"user_status":"membership-status-refunded","firstname":"aff1000","lastname":"aff1000","email":"user1@gmail.com","is_vendor":"0","profile_image":"http:\/\/localhost.aff.com\/aff\/7-0-0-0\/assets\/vertical\/assets\/images\/no-image.jpg"}}</pre>
         </div>
      </div>
      <!-- END TABLE HOVER -->
   </div>
</div>
<!-- end my profile details -->



<!-- start update my profile -->
<div class="top-content" id="update_my_profile">
   <h3 class="page-title">Update My Profile</h3>
   <p>Update my profile with HTTP POST request. with formate is Content-Type : multipart/form-data</p>
   <p>API token is required for the authentication of the calling program to the API.</p>
   <p>Here you can update your record and pass all parameter. uploads image set in file formate  also updated data return in your update response. country_id data get using get countrie list api.</p>
</div>
<div class="row">
   <div class="col-md-6">
      <!-- TABLE HOVER -->
      <div class="panel white">
         <div class="panel-heading">
            <h3 class="panel-title">Request :  </h3><br>
            <span class="text-warning">POST</span> : <?=base_url();?>User/update_my_profile</p>
         </div>
         <div class="panel-body">
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th>Parameter</th>
                     <th>Type</th>
                     <th>Required</th>
                     <th>Description</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>firstname</td>
                     <td><code>string</code></td>
                     <td><code>true</code></td>
                     <td>-</td>
                  </tr>
                  <tr>
                     <td>lastname</td>
                     <td><code>string</code></td>
                     <td><code>true</code></td>
                     <td>-</td>
                  </tr>
                  <tr>
                     <td>username</td>
                     <td><code>string</code> <code>number</code></td>
                     <td><code>true</code></td>
                     <td>your unique username</td>
                  </tr>
                  <tr>
                     <td>email</td>
                     <td><code>string</code></td>
                     <td><code>true</code></td>
                     <td>-</td>
                  </tr>
                  <tr>
                     <td>password</td>
                     <td><code>string</code> <code>number</code> <code>special character</code></td>
                     <td><code>true</code></td>
                     <td>-</td>
                  </tr>
                  <tr>
                     <td>cpassword</td>
                     <td><code>string</code> <code>number</code> <code>special character</code></td>
                     <td><code>true</code></td>
                     <td>password confirmation</td>
                  </tr>
                  <tr>
                     <td>device_type</td>
                     <td><code>number</code></td>
                     <td><code>true</code></td>
                     <td>(1 = android, 2 = ios)</td>
                  </tr>
                  <tr>
                     <td>device_token</td>
                     <td><code>string</code></td>
                     <td><code>true</code></td>
                     <td>-</td>
                  </tr>

                  <?php foreach ($registration_fields as $field) {
                     if($field['type'] != 'header') {
                        ?>
                        <tr>
                           <td>custom_<?= $field['name']; ?></td>
                           <td><code><?= ($field['mobile_validation']) ? 'Mobile Number' : $field['type']; ?></code></td>
                           <td><code><?= ($field['required']) ? 'true' : 'false'; ?></code></td>
                           <td><?= str_replace('Enter ', '', $field['placeholder']); ?></td>
                        </tr>
                        <?php
                     }
                  } ?>
               </tbody>
            </table>
         </div>
      </div>
      <!-- END TABLE HOVER -->
   </div>
   <div class="col-md-6">
      <!-- TABLE HOVER -->
      <div class="panel black">
         <div class="panel-heading">
            <h3 class="panel-title">Response</h3>
         </div>
         <div class="panel-body">
            <pre class="response-view">{"status":true,"message":"user details update successfully","data":{"id":"88","plan_id":"41","refid":"0","type":"user","firstname":"test","lastname":"user","email":"fresh_user2@mailinator.com","username":"fresh_user2","password":"3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d","phone":null,"twaddress":"","address1":"","address2":"","ucity":null,"ucountry":"1","state":null,"uzip":"","avatar":"","online":"0","unique_url":"","bitly_unique_url":"","updated_at":"2021-06-11 16:44:16","google_id":"","facebook_id":"","twitter_id":"","umode":"","PhoneNumber":"","Addressone":"","Addresstwo":"","City":"","Country":"1","StateProvince":"","Zip":"","f_link":"","t_link":"","l_link":"","products_wishlist":null,"product_commission":"0","affiliate_commission":"0","product_commission_paid":"0","affiliate_commission_paid":"0","product_total_click":"0","product_total_sale":"0","affiliate_total_click":"0","sale_commission":"0","sale_commission_paid":"0","status":"1","reg_approved":"1","is_vendor":"0","value":"{\"device_type\":\"1\",\"device_token\":\"FDSFDGGHGFHG45646fDGDGDgd53g456FGDGd56g6sdgf+6dgd\",\"custom_textarea-1623347397482\":\"some test meessage here\"}","last_ping":"2021-06-11 15:20:25","install_location_details":"","token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjIwMjEtMDYtMTEgMTc6MjA6NDRmcmVzaF91c2VyMiI.qWPzdYF2gDDQRoU4x8eR6WrkfQCPw-ONp3mcqsq05lc","created_at":"2021-06-11 16:44:16","device_type":"1","device_token":"FDSFDGGHGFHG45646fDGDGDgd53g456FGDGd56g6sdgf+6dgd","groups":null}}</pre>
         </div>
      </div>
      <!-- END TABLE HOVER -->
   </div>
</div>
<!-- end update my profile -->