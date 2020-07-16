<?php
$conn = mysqli_connect('localhost','root','','MITappinventor');

$nome = $_POST['username'];
$data_nasc = $_POST['data_nasc'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpf_user = $_POST['cpf_user'];
$endereco = $_POST['endereco'];

mysqli_query($conn,'INSERT INTO contact_info(nome,data_nasc,telefone,email,senha,cpf,endereco)'
. 'VALUES("$nome","$data_nasc","$phone_number","$email","$password","$cpf_user","$endereco")');

