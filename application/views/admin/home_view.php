<?php $this->load->view('common/head') ?>
<?php $this->load->view('common/header') ?>
</head>
<body>
    <div id="wrapper">
        <div id="top">
            <div id="header">
                <?php $this->load->view('common/headcontent') ?>
                <?php $this->load->view('common/navbar') ?>
            </div>
        </div>
        <div id="center">
            <div id="center2">
                <div id="content">
    					
                    <h1>Welcome to CodeIgniter!</h1>

                    <p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

                    <p>If you would like to edit this page you'll find it located at:</p>
                    <code>system/application/views/welcome_message.php</code>

                    <p>The corresponding controller for this page is found at:</p>
                    <code>system/application/controllers/welcome.php</code>

                    <p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
                	<div class="form" style="width:500px;">
                		<form action="" method="GET">
            				<div class="formleft">Nama</div><div class="formright"><input type="text" name="nama" value="" /></div>
            				<div class="clearboth"></div>

                			
            				<div class="formleft">Email</div><div class="formright"><input type="text" name="nama" value="" /></div>
            			
            				<div class="formleft">About</div><textarea name="about"></textarea>
            				<div class="clearboth"></div>
            			
            				<div class="formleft">Avatar</div><div class="formright"><input type="text" name="nama" value="" /></div>
            				<div class="clearboth"></div>
            			
            				<div class="formleft">Gender</div><div class="formright"><input type="radio" name="gender" value="co" />Lelaki<input type="radio" name="gender" value="ce" />Perempuan</div>
            				<div class="clearboth"></div>
            			
            				<div class="formleft">Negara</div>
            				<div class="formright"><select name="country">
            					<option value="Japan">Japan</option>
		                		<option value="Chinna">Chinna</option>
		                		<option value="English">English</option>
		                		<option value="Indonesia">Indonesia</option>
            				</select></div>
            				<div class="clearboth"></div>
            					
                			<div class="formleft">&nbsp;</div><div class="formright"><input type="submit" value="Post" /></div>
                			<div class="clearboth"></div>
                		</form>
                	</div>
                </div>                
            </div>
        </div>
        <?php $this->load->view('common/footer') ?>
    </div>
<?php $this->load->view('common/foot') ?>