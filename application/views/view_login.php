<?php
    if (isset($texto))
        echo "<h2>$texto</h2>";
    if (isset($error))
        echo "<h4 style='color: red'>$error</h2>";

    $this->load->helper("form");
    echo form_open("principal/check_login");
    echo form_label("Nombre de usuario", "usr");
    echo form_input("usr", "");
    echo form_label("Password", "pass");
    echo form_password("pass", "");
    echo form_submit("enviar", "Entrar");
    echo form_close();
    
    $this->load->helper('url');
    echo "<p align='center'><a href='".site_url('principal/show_formadd_user')."'>Registrarse</a></p>";
?>