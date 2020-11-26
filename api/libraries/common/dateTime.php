<?php
	/******************************************************/
	/*	Desarrollado por: Multimedia Service S.A. © 2017	*/
	/******************************************************/
	
	//Funcion para calcular el equivalente en timestamp de horas, dias o semanas
	function calculaTiempo( $rango, $cantidad )
	{
		$tiempo = 0;
		switch($rango)
		{
			//Horas
			case 1:
			$tiempo = $cantidad*60*60;
			break;
			//Dias
			case 2:
			$tiempo = $cantidad*60*60*24;
			break;
			//Semanas
			case 3:
			$tiempo = $cantidad*60*60*24*7;
			break;
		}
		return $tiempo;
	}
	
	function dateDia($dia)
	{
		$cDia="";
		switch ($dia)
		{
			case "Monday":
				$cDia="Lunes";
				break;
			case "Tuesday":
				$cDia="Martes";
				break;
			case "Wednesday":
				$cDia="Miércoles";
				break;
			case "Thursday":
				$cDia="Jueves";
				break;
			case "Friday":
				$cDia="Viernes";
				break;
			case "Saturday":
				$cDia="Sábado";
				break;
			default:
				$cDia="Domingo";
				break;
		}
		return $cDia;
	}
	function dateMes($mes)
	{
		$cMes="";
		switch ($mes)
		{
			case "January":
				$cMes="Enero";
				break;
			case "February":
				$cMes="Febrero";
				break;
			case "March":
				$cMes="Marzo";
				break;
			case "April":
				$cMes="Abril";
				break;
			case "May":
				$cMes="Mayo";
				break;
			case "June":
				$cMes="Junio";
				break;
			case "July":
				$cMes="Julio";
				break;
			case "August":
				$cMes="Agosto";
				break;
			case "September":
				$cMes="Septiembre";
				break;
			case "October":
				$cMes="Octubre";
				break;
			case "November":
				$cMes="Noviembre";
				break;
			default:
				$cMes="Diciembre";
				break;
		}
		return $cMes;
	}
?>