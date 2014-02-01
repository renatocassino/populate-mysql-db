<?php
	class LoremIpsumGenerator
	{
		private static $_lorem;

		protected $expression = 'Lorem ipsum sit dolor aimet';
		protected $qtWords = 10;

		private function __construct() {}

		private function __clone() {}

		protected $words = array(
				'lorem',        'ipsum',        'dolor',        'sit',          'amet',         'consectetur',
				'adipiscing',   'elit',         'curabitur',    'vel',          'hendrerit',    'libero',
				'eleifend',     'blandit',      'nunc',         'ornare',       'odio',         'ut',
				'orci',         'gravida',      'imperdiet',    'nullam',       'purus',        'lacinia',
				'a',            'pretium',      'quis',         'congue',       'praesent',     'sagittis',
				'laoreet',      'auctor',       'mauris',       'non',          'velit',        'eros',
				'dictum',       'proin',        'accumsan',     'sapien',       'nec',          'massa',
				'volutpat',     'venenatis',    'sed',          'eu',           'molestie',     'lacus',
				'quisque',      'porttitor',    'ligula',       'dui',          'mollis',       'tempus',
				'at',           'magna',        'vestibulum',   'turpis',       'ac',           'diam',
				'tincidunt',    'id',           'condimentum',  'enim',         'sodales',      'in',
				'hac',          'habitasse',    'platea',       'dictumst',     'aenean',       'neque',
				'fusce',        'augue',        'leo',          'eget',         'semper',       'mattis',
				'tortor',       'scelerisque',  'nulla',        'interdum',     'tellus',       'malesuada',
				'rhoncus',      'porta',        'sem',          'aliquet',      'et',           'nam',
				'suspendisse',  'potenti',      'vivamus',      'luctus',       'fringilla',    'erat',
				'donec',        'justo',        'vehicula',     'ultricies',    'varius',       'ante',
				'primis',       'faucibus',     'ultrices',     'posuere',      'cubilia',      'curae',
				'etiam',        'cursus',       'aliquam',      'quam',         'dapibus',      'nisl',
				'feugiat',      'egestas',      'class',        'aptent',       'taciti',       'sociosqu',
				'ad',           'litora',       'torquent',     'per',          'conubia',      'nostra',
				'inceptos',     'himenaeos',    'phasellus',    'nibh',         'pulvinar',     'vitae',
				'urna',         'iaculis',      'lobortis',     'nisi',         'viverra',      'arcu',
				'morbi',        'pellentesque', 'metus',        'commodo',      'ut',           'facilisis',
				'felis',        'tristique',    'ullamcorper',  'placerat',     'aenean',       'convallis',
				'sollicitudin', 'integer',      'rutrum',       'duis',         'est',          'etiam',
				'bibendum',     'donec',        'pharetra',     'vulputate',    'maecenas',     'mi',
				'fermentum',    'consequat',    'suscipit',     'aliquam',      'habitant',     'senectus',
				'netus',        'fames',        'quisque',      'euismod',      'curabitur',    'lectus',
				'elementum',    'tempor',       'risus',        'cras'
		);

		public static function getInstance()
		{
			if(!isset(self::$_lorem))
				self::$_lorem = new self;
			return self::$_lorem;
		}

		private function _prepare() {
			$this->qtWords = count($this->words) - 1;
		}

		public function generateWords($qtChars = 50)
		{
			$chars = 'abcdefghijklmnopqrstuvwxyz ';
			$qtPossibleChars = count($chars)-1;

			$return = '';
			for($i = 0; $i < $qtChars-1; $i++)
			{
				$upper = false;
				$char = $chars[rand(0,$qtPossibleChars)];

				$return .= ($upper) ? strtoupper($char) : $char;

				if($char == ' ')
					$upper = rand(0,10) % 2 == 0 ? true : false;
			}

			return $return . '.';
		}

		private function _generateWord()
		{
			return $this->words[rand(0,$this->qtWords)];
		}

		public function generateByChars($minChars = 45, $maxChars = 200, $beginWithLoremIpsum = true)
		{
			$this->_prepare();

			$qtChars = 0;
			$result = false;

			while($qtChars < $minChars)
			{
				if(!$result)
					$result = ($beginWithLoremIpsum) ? $this->expression : $this->_generateWord();
				else
					$result .= ' ' . $this->_generateWord();

				$qtChars = strlen($result);
			}

			if($qtChars > $maxChars)
				$result = substr(0,$maxChars,$result);

			return $result;
		}
		
		public function generateByParagraph($qtParagraph,$isHtml = true)
		{
			$paragraphs = [];
			for($i = 0; $i < $qtParagraph; $i++)
			{
				$paragraphs[] = $this->generateByWords(rand(40,100),false,true);
			}
			
			return $isHtml ?
				'<p>' . implode('</p><p>',$paragraphs) . '</p>' :
				implode(PHP_EOL,$paragraphs);
		}

		public function generateByWords($qtWords = 50, $beginWithLoremIpsum = true,$dot = true)
		{
			$this->_prepare();

			$result = ($beginWithLoremIpsum) ? $this->expression : '';
			$qtWords = ($beginWithLoremIpsum) ? $qtWords - 2 : $qtWords;

			$words = [];
			for($i = 0; $i < $qtWords; $i++)
				$words[] = $this->_generateWord();

			return ($dot) ?
					$result . ' ' . implode(' ',$words) . '.' :
					$result . ' ' . implode(' ',$words);
		}
	}
?>