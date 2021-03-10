<?php
header('Access-Control-Allow-Origin: *');						
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=utf-8");

function conectar(){
	$user="uotryowypietcsd1";
	$pass="dSlFzxmVRhZsPw0ilLDx";
	$server="bv6xput9wz5gqtoj2g9f-mysql.services.clever-cloud.com";
	$db="bv6xput9wz5gqtoj2g9f";
	try {
		$con=mysqli_connect($server, $user, $pass, $db, 3306);
		return $con;
	} catch (\Throwable $th) {
		return 'no hay';
	}
}

// function conectar()
// {
// 	$user = "root";
// 	$pass = "";
// 	$server = "localhost";
// 	$db = "bv6xput9wz5gqtoj2g9f";
// 	$con = mysqli_connect($server, $user, $pass, $db, 3306);
// 	return $con;
// }

// -------------------------------- GET ---------------------------- //
if (isset($_GET["id"])) {
	if ($_GET["id"] == 1) {
		$query = "SELECT * FROM diario WHERE nombre = DATE(NOW()) AND id_estado = 5";
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}

		$json = array();
		while ($row = mysqli_fetch_array($result)) {
			$json[] = array(
				'id' => $row["id"],
				'nombre' => $row["nombre"]
			);
		}
		$json_string = json_encode($json);
		echo $json_string;
	}
}

if (isset($_GET["quest"])) {
	// VER SI HAY DIARIO DUPLICADOS
	if ($_GET["quest"] == "duplicado") {
		$query = "SELECT * FROM diario WHERE nombre = DATE(NOW())";
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}
		if (mysqli_num_rows($result) > 0) {
			echo 'SI';
		} else {
			echo 'NO';
		}
	}
	// TRAE OBSERVACIONES
	if ($_GET["quest"] == "observacion") {
		$query_2 = "SELECT observaciones FROM diario WHERE nombre = DATE(NOW())";
		$result_2 = mysqli_query(conectar(), $query_2);

		if (!$result_2) {
			die('Query 2 Falló ' . mysqli_error(conectar()));
		}

		while ($fila = mysqli_fetch_array($result_2)) {
			if ($fila["observaciones"] == "") {
				$obs = ".";
			} else {
				$obs = $fila["observaciones"];
			}
			echo $obs;
		}
	}
	// TRAE DETALLE PEDIDO
	if ($_GET["quest"] == "detalle_pedido") {
		$query = "SELECT nombre_cliente FROM pedidos WHERE id = " . $_GET["id_pedido"];
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			die('Query 2 Falló ' . mysqli_error(conectar()));
		}

		while ($fila = mysqli_fetch_array($result)) {
			$nombre_cliente = $fila["nombre_cliente"];
		}

		echo $nombre_cliente;
	}
	// LISTA DE PRODUCTOS
	if ($_GET["quest"] == "productos") {
		$query = "SELECT * FROM producto";
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}

		$json = array();
		while ($row = mysqli_fetch_array($result)) {
			$json[] = array(
				'id' => $row["id"],
				'nombre' => $row["nombre"]
			);
		}
		$json_string = json_encode($json);
		echo $json_string;
	}
	// DETALLE DE PRODUCTOS
	if ($_GET["quest"] == "producto") {
		$query = "SELECT * FROM producto WHERE id = " . $_GET["id_producto"];
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}

		$json = array();
		while ($row = mysqli_fetch_array($result)) {
			$json[] = array(
				'id' => $row["id"],
				'nombre' => $row["nombre"],
				'descripción' => $row["descripcion"],
				'precio' => $row["precio"]
			);
		}
		$json_string = json_encode($json);
		echo $json_string;
	}
	// TOPPINGS
	if ($_GET["quest"] == "topping") {
		$query = "SELECT * FROM toppings";
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}

		$json = array();
		while ($row = mysqli_fetch_array($result)) {
			$json[] = array(
				'id' => $row["id"],
				'nombre' => $row["nombre"]
			);
		}
		$json_string = json_encode($json);
		echo $json_string;
	}
	// LOGIN
	if ($_GET["quest"] == "login") {
		$query = "SELECT * FROM usuario WHERE usuario = '" . $_GET["usuario"] . "' AND contrasena = '" . $_GET["contrasena"] . "'";
		$result = mysqli_query(conectar(), $query);
		// echo $query;
		// echo hash($_GET["contrasena"]);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}

		if (mysqli_num_rows($result) == 1) {
			while ($fila = mysqli_fetch_array($result)) {
				echo $fila["id"];
			}
		} else if (mysqli_num_rows($result) > 1) {
			echo '-/-';
		} else if (mysqli_num_rows($result) == 0) {
			echo 'NO';
		} else {
			echo '¿Que?';
		}
	}
	// LISTA PRODUCTOS
	if ($_GET["quest"] == "admin_productos") {
		$query = "SELECT * FROM producto";
		$result = mysqli_query(conectar(), $query);
		// echo $query;
		// echo hash($_GET["contrasena"]);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}
		
		$json = array();
		while ($row = mysqli_fetch_array($result)) {
			$json[] = array(
				'id' => $row["id"],
				'nombre' => $row["nombre"]
			);
		}
		$json_string = json_encode($json);
		echo $json_string;
	}
	// LISTA PRODUCTOS
	if ($_GET["quest"] == "admin_productos_especifico") {
		$query = "SELECT * FROM producto WHERE id = ".$_GET["id_producto"];
		$result = mysqli_query(conectar(), $query);
		// echo $query;
		// echo hash($_GET["contrasena"]);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}
		
		$json = array();
		while ($row = mysqli_fetch_array($result)) {
			$json[] = array(
				'id' => $row["id"],
				'nombre' => $row["nombre"],
				'descripcion' => $row["descripcion"],
				'precio' => $row["precio"],
				'inversion' => $row["inversion"],
				'estado' => $row["estado"]
			);
		}
		$json_string = json_encode($json);
		echo $json_string;
	}
	// LISTA PRODUCTOS
	if ($_GET["quest"] == "admin_toppings") {
		$query = "SELECT * FROM toppings";
		$result = mysqli_query(conectar(), $query);
		// echo $query;
		// echo hash($_GET["contrasena"]);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}
		
		$json = array();
		while ($row = mysqli_fetch_array($result)) {
			$json[] = array(
				'id' => $row["id"],
				'nombre' => $row["nombre"]
			);
		}
		$json_string = json_encode($json);
		echo $json_string;
	}
	// admin_topping_especifico
	if ($_GET["quest"] == "admin_topping_especifico") {
		$query = "SELECT * FROM toppings WHERE id = ".$_GET["id_topping"];
		$result = mysqli_query(conectar(), $query);
		// echo $query;
		// echo hash($_GET["contrasena"]);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}
		
		$json = array();
		while ($row = mysqli_fetch_array($result)) {
			$json[] = array(
				'id' => $row["id"],
				'nombre' => $row["nombre"]
			);
		}
		$json_string = json_encode($json);
		echo $json_string;
	}
	// VER SI HAY DIARIO DUPLICADOS
	if ($_GET["quest"] == "conectado") {
		$user="uotryowypietcsd1";
		$pass="dSlFzxmVRhZsPw0ilLDx";
		$server="bv6xput9wz5gqtoj2g9f-mysql.services.clever-cloud.com";
		$db="bv6xput9wz5gqtoj2g9f";
		try {
			$con=mysqli_connect($server, $user, $pass, $db, 3306);
			return $con;
		} catch (\Throwable $th) {
			return 'no hay';
		}
	}
}
// ----------------------------------------- POST -------------------------------------- //
if (isset($_POST["quest"])) {
	// DIARIO
	if ($_POST["quest"] == 'diario') {
		$query = "INSERT INTO diario(nombre, encargado, cajero, id_estado) VALUES('" . $_POST["fecha"] . "', '" . $_POST["encargado"] . "', '" . $_POST["cajero"] . "', 5)";
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}

		echo 'Successfuly';
	}
	// GASTO
	if ($_POST["quest"] == 'gasto') {
		$query_2 = "SELECT id FROM diario WHERE nombre = DATE(NOW())";
		$result_2 = mysqli_query(conectar(), $query_2);

		if (!$result_2) {
			die('Query 2 Falló ' . mysqli_error(conectar()));
		}

		while ($fila = mysqli_fetch_array($result_2)) {
			$id_diario = $fila["id"];
		}

		$query = "INSERT INTO gastos(descripcion, costo, id_diario) VALUES('" . $_POST["descripcion"] . "', '" . $_POST["gasto"] . "', '" . $id_diario . "')";
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}

		echo 'Successfuly';
	}
	// OBSERVACION
	if ($_POST["quest"] == "set_observacion") {
		$query_2 = "SELECT id FROM diario WHERE nombre = DATE(NOW())";
		$result_2 = mysqli_query(conectar(), $query_2);

		if (!$result_2) {
			die('Query 2 Falló ' . mysqli_error(conectar()));
		}

		while ($fila = mysqli_fetch_array($result_2)) {
			$id_diario = $fila["id"];
		}

		$query = "UPDATE diario SET observaciones =  '" . $_POST["observaciones"] . "' WHERE id = " . $id_diario;
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			echo $query;
			die('Query Falló ' . mysqli_error(conectar()));
		}

		echo 'Successfuly';
	}
	// FINALIZAR UN DÍA
	if ($_POST["quest"] == "finalizar_dia") {
		$query = "UPDATE diario SET id_estado = 6 WHERE nombre = DATE(NOW())";
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			echo $query;
			die('Query Falló ' . mysqli_error(conectar()));
		}

		echo 'Successfuly';
	}
	// INGRESAR CLIENTE
	if ($_POST["quest"] == "set_cliente") {
		$query = "SELECT id FROM diario WHERE nombre = DATE(NOW())";
		$result = mysqli_query(conectar(), $query);
		if (!$result) {
			echo $query;
			die('Query Falló ' . mysqli_error(conectar()));
		}
		while ($fila = mysqli_fetch_array($result)) {
			$id_diario = $fila["id"];
		}

		$query_2 = "INSERT INTO pedidos(id_diario, nombre_cliente, id_estado, hora_de_ingreso) VALUES(" . $id_diario . ", '" . $_POST["nombre_cliente"] . "', 7, NOW())";
		$result_2 = mysqli_query(conectar(), $query_2);
		if (!$result_2) {
			echo $query_2;
			die('Query Falló ' . mysqli_error(conectar()));
		}

		$query_3 = "SELECT id FROM `pedidos` ORDER BY id DESC LIMIT 1";
		$result_3 = mysqli_query(conectar(), $query_3);
		if (!$result_3) {
			echo $query_3;
			die('Query Falló ' . mysqli_error(conectar()));
		}
		while ($fila = mysqli_fetch_array($result_3)) {
			$id_pedido = $fila["id"];
		}

		echo $id_pedido;
	}
	// CANCELAR PEDIDO
	if ($_POST["quest"] == "cancelar_pedido") {
		$query = "UPDATE pedidos SET id_estado = 4 WHERE id = " . $_POST["id_pedido"];
		$result = mysqli_query(conectar(), $query);

		if (!$result) {
			echo $query;
			die('Query Falló ' . mysqli_error(conectar()));
		}

		echo 'Successfuly';
	}
	//confirmar_pedido
	if ($_POST["quest"] == "confirmar_pedido") {

		$lista = json_decode($_POST["lista_productos"], true);

		$total;
		foreach ($lista as $fila) {
			$total = $total + $fila["total"];
			$mysql_0 = "UPDATE pedidos SET id_estado = 1 WHERE id = " . $_POST["id_pedido"];
			$res_0 = mysqli_query(conectar(), $mysql_0);

			if (!$res_0) {
				die('Query Falló ' . mysqli_error(conectar()));
			}

			$mysql = "INSERT INTO detalle_pedido(id_pedido, id_producto, cantidad, extra, total, observacion) VALUES(" . $_POST["id_pedido"] . ", " . $fila["id"] . ", " . $fila["cantidad"] . ", 0, " . $fila["total"] . ", '" . $fila["observacion"] . "')";
			$res = mysqli_query(conectar(), $mysql);

			if (!$res) {
				die('Query Falló ' . mysqli_error(conectar()));
			}

			echo $mysql;
		}
		$mysql_1 = "UPDATE pedidos SET venta = " . $total . " WHERE id = " . $_POST["id_pedido"];
		$res_1 = mysqli_query(conectar(), $mysql_1);

		if (!$res_1) {
			die('Query Falló ' . mysqli_error(conectar()));
		}
	}
	// cerrar_otros
	if ($_POST["quest"] == "cerrar_otros") {
		$mysqli = "UPDATE diario SET id_estado = 6";
		$mysqli_result = mysqli_query(conectar(), $mysqli);

		if (!$mysqli_result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}

		echo 'Successfully';
	}
	// Agregar Producto
	if ($_POST["quest"] == "agregar_producto") {
		$mysqli = "INSERT INTO producto(nombre, descripcion, precio, inversion, estado, id_usuario) VALUES('".$_POST["nombre"]."', '".$_POST["descripcion"]."', ".$_POST["precio"].", ".$_POST["inversion"].", ".$_POST["estado"].", ".$_POST["id_usuario"].")";
		$mysqli_result = mysqli_query(conectar(), $mysqli);

		if (!$mysqli_result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}

		echo 'Successfully';
	}
	// Actualizar Producto
	if ($_POST["quest"] == "actualizar_producto") {
		$mysqli = "UPDATE producto SET nombre = '".$_POST["nombre"]."', descripcion = '".$_POST["descripcion"]."', precio = ".$_POST["precio"].", inversion = ".$_POST["inversion"].", estado = ".$_POST["estado"].", id_usuario = ".$_POST["id_usuario"]." WHERE id = ".$_POST["id"];
		// echo $mysqli;
		$mysqli_result = mysqli_query(conectar(), $mysqli);
		if (!$mysqli_result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}
		echo 'Successfully';
	}
	// Agregar Toppings
	if ($_POST["quest"] == "agregar_topping") {
		$mysqli = "INSERT INTO toppings(nombre) VALUES ('".$_POST["nombre"]."')";
		// echo $mysqli;
		$mysqli_result = mysqli_query(conectar(), $mysqli);
		if (!$mysqli_result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}
		echo 'Successfully';
	}
	// actualizar_topping
	if ($_POST["quest"] == "actualizar_topping") {
		$mysqli = "UPDATE toppings SET nombre = '".$_POST["nombre"]."' WHERE id = ".$_POST["id"];
		// echo $mysqli;
		$mysqli_result = mysqli_query(conectar(), $mysqli);
		if (!$mysqli_result) {
			die('Query Falló ' . mysqli_error(conectar()));
		}
		echo 'Successfully';
	}
}
