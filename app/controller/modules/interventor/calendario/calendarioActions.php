<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class calendarioActions extends controller
	{
		private $prev_month;
		private $next_month;
		private $prev_year;
		private $next_year;
		private $prev_day = null;
		private $next_day = null;
		private $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		protected function index()
		{
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'anterior':
					$this->getFormData("anoActual", false);
					$this->getFormData("mesActual", false);

					$this->setPrevMonth($this->mesActual, $this->anoActual);


					$mes = $this->getPrevMonth();
					$ano = $this->getPrevYear();

					$fechaDespues = array(
						"mesPrev" => $mes,
						"anoPrev" => $ano,
						"ultimoDiaDelMes" => date("d",(mktime(0,0,0,$mes+1,1,$ano)-1)),
						"diaPrev" => $this->getPrevDay(),
						"diaDeLaSemanaInicial" => date("w",mktime(0,0,0,$mes,1,$ano)),
						"fechaStr" => $this->meses[$this->getPrevMonth()-1]." del ".$this->getPrevYear()
					);

					echo json_encode($fechaDespues);
					exit();
				break;
				case 'siguiente':
					$this->getFormData("anoActual", false);
					$this->getFormData("mesActual", false);

					$this->setNextMonth($this->mesActual, $this->anoActual);

					$mes = $this->getNextMonth();
					$ano = $this->getNextYear();

					$fechaDespues = array(
						"mesNext" => $mes,
						"anoNext" => $ano,
						"ultimoDiaDelMes" => date("d",(mktime(0,0,0,$mes+1,1,$ano)-1)),
						"diaNext" => $this->getNextDay(),
						"diaDeLaSemanaInicial" => date("w",mktime(0,0,0,$mes,1,$ano)),
						"fechaStr" => $this->meses[$this->getNextMonth()-1]." del ".$this->getNextYear()
					);
					
					echo json_encode($fechaDespues);
					exit();
			    break;
			  default:
			  	echo false;
			    return false;
			    exit();
			}

		}

		private function setPrevMonth($currMonth, $currYear){
			$currMonth = (int) $currMonth;
			$currYear = (int) $currYear;

			if($currMonth<=1){
				$this->setPrevYear($currYear-1);
				$this->prev_month = 12;
			}else{
				$this->setPrevYear($currYear);
				$this->prev_month = $currMonth-1;
			}
			
			if(((int)date("n")==$this->getPrevMonth()) && ((int)date("Y")==$this->getPrevYear()))
				$this->setPrevDay(date("j"));

		}

		private function getPrevMonth(){
			return $this->prev_month;
		}

		private function setPrevYear($prevYear){
			$this->prev_year = $prevYear;
		}

		private function getPrevYear(){
			return $this->prev_year;
		}

		private function setPrevDay($prevDay){
			$this->prev_day = $prevDay;
		}

		private function getPrevDay(){
			return $this->prev_day;
		}

		private function setNextMonth($currMonth, $currYear){
			$currMonth = (int) $currMonth;
			$currYear = (int) $currYear;			

			if($currMonth>=12){
				$this->setNextYear($currYear+1);
				$this->next_month = 1;
			}else{
				$this->setNextYear($currYear);
				$this->next_month = $currMonth+1;
			}

			if(((int)date("n")==$this->getNextMonth()) && ((int)date("Y")==$this->getNextYear()))
				$this->setNextDay(date("j"));
		}

		private function getNextMonth(){
			return $this->next_month;
		}

		private function setNextYear($nextYear){
			$this->next_year = $nextYear;
		}

		private function getNextYear(){
			return $this->next_year;
		}

		private function setNextDay($nextDay){
			$this->next_day = $nextDay;
		}

		private function getNextDay(){
			return $this->next_day;
		}

		public function render()
		{
			return "";
		}
	}
?>
