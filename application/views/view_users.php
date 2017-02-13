<style>
    .msg { color: green; text-align: center; }
    .error { color: red; text-align: center; }
</style>

<h4 align="center">Práctica de introducción a CodeIgniter</h4>
<h1 align="center">Administración de usuarios</h1>
<?php
$this->load->helper('url');
    // Si el controlador nos envía algún mensaje, lo mostramos
    if (isset($result))
         echo "<table align='center' ><tr><td><p class='msg'>$result</p></td></tr></table>";
?>
<p> </p>
<table border="1" align="center"> 
    <tr bgcolor="#bbb">
        <td>Username</td><td>Email</td><td>Teléfono</td><td>Foto de perfil</td><td colspan="2" align="center">Acciones</td>
    </tr>
    <tr>
 <?php
      foreach ($list_users as $user) {
          echo "<tr>";
          echo "<td>".$user['user']."</td><td>".$user['email']."</td><td>".$user['telef']."</td><td><img src='".base_url("img")."/".$user['img']."'/></td>";
          echo "<td><a href='users/update_user/".$user['id']."'>Modificar</a></td>";
          echo "<td><a href='users/delete_user/".$user['id']."'>Eliminar</a></td>";
          echo "</tr>";
      }
      
 ?>
    </tr>
</table>

<?php
    echo "<p align='center'><a href='".site_url('principal/show_formadd_user')."'>Nuevo</a></p>";
?>