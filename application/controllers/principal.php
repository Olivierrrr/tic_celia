<?php
    class Principal extends CI_Controller {
        
         public function index() {
            $data['texto'] = 'Bienvenido a nuestra web app';
            $this->load->view('view_login', $data);
        }
        
        public function check_login() {
            $this->load->model('model_login');
            $usr = $this->input->get_post("usr");
            $idusr = $this->model_login->check_login($this->input->get_post("usr"), $this->input->get_post("pass"));
	    if ($idusr > 0) {
                    $this->load->library('session');
                    $sesion = array('idusr'  => $idusr);
                    $this->session->set_userdata($sesion);
                    $cookie = array('name' => 'idusr', 'value'  => $idusr, 'expire' => '86500');
                    $this->input->set_cookie($cookie);
                    $ok = 1;
            }
            else {
                    $ok = 0;   
            }
            echo "<a href='http://localhost/TIC/index.php/principal/result_login/$ok/$usr'>Datos recibidos. Continuar</a>";

        }

        public function result_login($ok, $usr) {
	    if ($ok == 1) {
                $this->load->library("session");
                echo "<h1>Bienvenido, $usr</h1>";
                echo "<h4>Estás dentro de la aplicación</h4>";
                echo "<p>Se ha creado la cookie idusr con el valor: ".$this->input->cookie("idusr", TRUE)."</p>";
                echo "Y una variable de sesión con el idusr con el valor: ".$this->session->userdata("idusr")."</p>";
                echo "(Aquí iría el panel de administración, o lo que sea)";
            }
            else {
                echo "El usuario $usr no existe";
            }
        }
        
         public function show_formadd_user() {
            $this->load->view("view_formadd_user");
        }
        
        public function add_user() {
            // Cargamos el modelo y la librería de validación de formularios
            $this->load->model("model_users");
            $this->load->library('form_validation');

            // Establecemos las reglas de validación
            $this->form_validation->set_rules('user', 'Nombre de usuario', 'required');
            $this->form_validation->set_rules('pass', 'Contraseña', 'required|matches[pass2]');
            $this->form_validation->set_rules('pass2', 'Confirmación de contraseña', 'required');
            
            // Establecemos los mensajes de error para las reglas anteriores
            $this->form_validation->set_message('required', 'El campo %s es obligatorio');
            $this->form_validation->set_message('matches', 'El campo %s debe coincidir con el campo %s');
            
            // Comprobamos las reglas de validación
            if ($this->form_validation->run() == FALSE) {
                // La validación ha fallado: volvemos a mostrar el formulario indicando los errores
                $this->load->view("view_formadd_user");
            }
            else {
                // La validación ha sido un éxito. Continuamos el proceso de agregar el usuario.
                // Ahora configuramos la subida de la imagen del perfil del usuario)
                $config['upload_path'] = 'img/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '20';
		$config['max_width']  = '80';
		$config['max_height']  = '80';
                
                $this->load->library('upload', $config);

                // Intentamos subir la imagen al servidor
		if ( ! $this->upload->do_upload())
		{
                        // Ha fallado la subida de la imagen
			$data['error'] = $this->upload->display_errors();
                        $this->load->view("view_formadd_user", $data);
		}
		else
		{
                    // Obtenemos el filename de la imagen subida
                    $upload_img_data = $this->upload->data();
                    $upload_img_name = $upload_img_data['file_name'];
                    
                    // Pasamos todos los datos al modelo para que inserte el usuario en la BD
                    $r = $this->model_users->add_user($this->input->get_post('user'), $this->input->get_post('pass'), $this->input->get_post('email'), $this->input->get_post('telef'), $upload_img_name);

                    // Generamos un texto con el resultado de la inserción
                    if ($r == "ok") 
                            $data["result"] = "Usuario añadido con éxito";
                    else if ($r == "user_exists") 
                            $data["result"] = "El nombre de usuario ya existe";
                    else if ($r == "email_exists") 
                            $data["result"] = "El email ya existe";
                    else 
                            $data["result"] = "Error desconocido al insertar al usuario. Inténtelo más tarde";

                    // Mostramos el resultado de la inserción en la vista de usuarios
                    $data["list_users"] = $this->model_users->get_all_users();
                    $this->load->view("view_users", $data);
                }
            }
        }
        
    }