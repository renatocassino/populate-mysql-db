<?php
	namespace Populate;

	class Populate
	{
		protected $pdo;
		protected $fields = false;
		protected $tableName;
		protected $lorem;
		protected $beginWithLoremIpsum;
		protected $fixValues;

		public function setPDO(&$pdo)
		{
			$this->pdo = $pdo;
		}
		
		public function beginWithLoremIpsum($bool)
		{
			$this->beginWithLoremIpsum = $bool;
		}

		public function __construct($host = null, $user = null, $pass = null, $dbname = null)
		{
			$this->lorem = LoremIpsumGenerator::getInstance();

			if(!is_null($host))
			{
				$this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$pass);

				if(!$this->pdo)
					throw new Exception("Connection error!");

				return true;
			}
		}

		/**
		 * Setting the table and checking if this one exists.
		 */
		public function setTable($tableName)
		{
			$stmt = $this->pdo->query("SHOW TABLES LIKE '$tableName';")->fetch();
			if($stmt)
			{
				$this->tableName = $tableName;
				$this->_describeTable();
				return true;
			}

			throw new Exception("Couldn't find the table " . $tableName . '.');
		}

		public function setFixValue($field,$value)
		{
			$this->fixValues[$field] = $value;
		}

		private function _describeTable()
		{
			$stmt = $this->pdo->prepare("DESCRIBE " . $this->tableName);
			$stmt->execute();

			$this->fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
			var_dump($this->fields);
		}
		
		private function _getFields()
		{
			if(!$this->fields || !is_array($this->fields))
				throw new Exception("You need to set a valid table first.");

			$fields = [];
			foreach($this->fields as $f)
				$fields[] = '`' . $f['Field'] . '`';

			return implode(',',$fields);
		}

		private function _getValueLine()
		{
			$fields = [];

			foreach($this->fields as $f)
			{
				if(isset($this->fixValues[$f["Field"]]))
				{
					$fields[] = '"' . $this->fixValues[$f["Field"]] . '"';
					continue;
				}

				if(preg_match('/^int\(([0-9]+)\)/',$f["Type"], $matches))
				{
					if($f["Key"] == "PRI" && $f["Extra"] == "auto_increment")
					{
						$fields[] = "null";
						continue;
					}

					$maxValue = (int)str_repeat('9',$matches[1]);

					if(preg_match('/unsigned$/',$f["Type"]))
						$min = 1;
					else
						$min = $maxValue * -1;

					$fields[] = rand($min,$maxValue); continue;
				}

				if(preg_match('/varchar\(([0-9]+)\)/',$f["Type"],$matches))
				{
					$min = (int)$matches[1] / 2;
					$fields[] = '"' . addslashes($this->lorem->generateByChars($min,$matches[1],$this->beginWithLoremIpsum)) . '"'; continue;
				}

				if(preg_match('/^bigint\(([0-9]+)\)/',$f["Type"],$matches))
				{
					$max = (int)str_repeat('1',$matches[1]);

					if(preg_match('/unsigned$/',$f["Type"]))
						$min = 1;
					else
						$min = $max * -1;
					$fields[] = rand($min,$max); continue;
				}

				if(preg_match('/^tinyint\(([0-9]+)\)/',$f["Type"],$matches))
				{
					$max = (int)str_repeat('1',$matches[1]);

					if(preg_match('/unsigned$/',$f["Type"]))
						$min = 1;
					else
						$min = $max * -1;
					$fields[] = rand($min,$max); continue;
				}

				if(preg_match('/^smallint\(([0-9]+)\)/',$f["Type"],$matches))
				{
					$max = (int)str_repeat('1',$matches[1]);

					if(preg_match('/unsigned$/',$f["Type"]))
						$min = 1;
					else
						$min = $max * -1;
					$fields[] = rand($min,$max); continue;
				}

				if(preg_match('/^mediumint\(([0-9]+)\)/',$f["Type"],$matches))
				{
					$max = (int)str_repeat('1',$matches[1]);

					if(preg_match('/unsigned$/',$f["Type"]))
						$min = 1;
					else
						$min = $max * -1;
					$fields[] = rand($min,$max); continue;
				}

				switch(strtolower($f["Type"]))
				{
					case "float":
					case "double":
						$fields[] = rand(0,100) / 10; break;
					case "text":
						$fields[] = '"' . addslashes($this->lorem->generateByParagraph(5,true)) . '"'; break;
					case "date":
						$fields[] = '"' . date('Y-m-d',rand(strtotime("-3 year"),strtotime("now"))) . '"'; break;
					case "datetime":
						$fields[] = '"' . date('Y-m-d H:i:s',rand(strtotime("-3 year"),strtotime("now"))) . '"'; break;
				}
			}

			return implode(' , ',$fields);
		}

		public function insert($qt=3)
		{
			$query = "INSERT INTO `{$this->tableName}` (";
			$query .= $this->_getFields();
			$query .= ") VALUES " . PHP_EOL;

			$values = [];
			for($i = 0; $i < $qt; $i++)
			{
				$values[$i] = '(' . $this->_getValueLine() . ')';
			}

			$query .= implode(',' . PHP_EOL,$values);

			$run = $this->pdo->query($query);

			echo 'Loading...' . PHP_EOL;

			if($run)
				return 'Finished.' . PHP_EOL;
			else
				throw new Exception(var_dump( $this->pdo->errorInfo() ));
		}

		public function clear()
		{
			echo 'Loading...' . PHP_EOL;

			$query = "TRUNCATE TABLE `{$this->tableName}`";
			$run = $this->pdo->query($query);

			if($run)
				return 'Finished.' . PHP_EOL;
			else
				throw new Exception(var_dump( $this->pdo->errorInfo() ));
		}
	}
?>
