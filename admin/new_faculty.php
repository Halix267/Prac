<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Easiest Way to Add Input Masks to Your Forms</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php
?>
    <div class="registration-form">
        <form action="" id="manage_faculty">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-icon">
                <span><i class="icon icon-user"></i></span>
            </div>
            <div class="form-group">
							
				<input type="text" name="school_id" class="form-control item" placeholder="ID" required value="<?php echo isset($school_id) ? $school_id : '' ?>">
			</div>
			<div class="form-group">
							
			<input type="text" name="firstname" class="form-control item" placeholder ="First Name" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
			</div>
			<div class="form-group">
				
				<input type="text" name="lastname" class="form-control item" placeholder="Last Name" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
			</div>
            <div class="form-group">
							
				<input type="email" class="form-control item" placeholder="Email" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
				<small id="#msg"></small>
			</div>
			<div class="form-group">
							
				<input type="password" class="form-control item" placeholder="Password" name="password" <?php echo !isset($id) ? "required":'' ?>>
							<small><i><?php echo isset($id) ? "Leave this blank if you dont want to change you password":'' ?></i></small>
			</div>
			<div class="form-group">
							
				<input type="password" class="form-control item" placeholder ="Confirm Password" name="cpass" <?php echo !isset($id) ? 'required' : '' ?>>
							<small id="pass_match" data-status=''></small>
			</div>
            <div class="form-group">
					<input type="text" name="contact" class="form-control item" placeholder="Phone Number" required value="<?php echo isset($contact) ? $contact : '' ?>">
			</div>
			<div class="form-group">
							
				<input type="text" name="address" class="form-control item" placeholder="Address" required value="<?php echo isset($address) ? $address : '' ?>">
			</div>
			
			<div class="form-group">
							
							<div class="custom-file">
		                      <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
		                      <label class="custom-file-label" for="customFile">Photo</label>
		                    </div>
						</div>
						
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Submit</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=student_list'">Back</button>
				</div>
        </form>
        
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
<script>
	$('[name="password"],[name="cpass"]').keyup(function(){
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if(cpass == '' ||pass == ''){
			$('#pass_match').attr('data-status','')
		}else{
			if(cpass == pass){
				$('#pass_match').attr('data-status','1').html('<i class="text-success">Password Matched.</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">Password does not match.</i>')
			}
		}
	})
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_faculty').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		if($('[name="password"]').val() != '' && $('[name="cpass"]').val() != ''){
			if($('#pass_match').attr('data-status') != 1){
				if($("[name='password']").val() !=''){
					$('[name="password"],[name="cpass"]').addClass("border-danger")
					end_load()
					return false;
				}
			}
		}
		$.ajax({
			url:'ajax.php?action=save_faculty',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=faculty_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}else if(resp == 3){
					$('#msg').html("<div class='alert alert-danger'>School ID already exist.</div>");
					$('[name="school_id"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>
</html>
