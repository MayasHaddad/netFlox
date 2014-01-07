<?php
class MovieEngine
{
	var $movieTree;
	var $XpathTree;

	protected $pathToMovieData;
	
	public function __construct($initialContext) 
	{		
		$this->pathToMovieData = $initialContext . 'data/movie.xml';
		
		$this->movieTree = $this->loadMovies();
		$this->XPathTree = new DOMXPath($this->movieTree);		
	}
	
	public function addMovie($titre, $jour, $mois, $annee, $description, $acteur, $realisateur)
	{
		$racine = $this->movieTree->getElementsByTagName('movies');
		$movies = $racine->item(0);
		
		$movie = $this->movieTree->createElement('movie', '');
		$title = $this->movieTree->createElement('title', $titre);
		$dateDeSortie = $this->movieTree->createElement('date', '');
		$jourr = $this->movieTree->createElement('day', $jour);
		$moiss = $this->movieTree->createElement('month', $mois);
		$anneee = $this->movieTree->createElement('year', $annee);
		$describe = $this->movieTree->createElement('description', $description);
		$actor = $this->movieTree->createElement('actor', $acteur);
		$director = $this->movieTree->createElement('director', $realisateur);
		
		$dateDeSortie->appendChild($jourr);
		$dateDeSortie->appendChild($moiss);
		$dateDeSortie->appendChild($anneee);
		
		$movie->appendChild($title);
		$movie->appendChild($dateDeSortie);
		$movie->appendChild($describe);
		$movie->appendChild($actor);
		$movie->appendChild($director);
		
		$idManager = new IdManager();
		$movies->appendChild($movie)->setAttribute('id', 't' . $idManager->getId());
		
		$this->movieTree->save($this->pathToMovieData);	
	}
	
	public function loadMovies()
	{
		$document_xml = new DomDocument(); 
		$document_xml->load($this->pathToMovieData);
		return $document_xml;
	}
	
	public function getXPathTree($docXML)
	{
		return new DOMXPath($docXML);	
	}
	
	public function getMovieByName($name)
	{
		$query = '//movie[title="'.$name.'"]';		
		$result = $this->XPathTree->query($query);
		$explodedMovie = $this->explodeMovie($result);
		return $explodedMovie;
	}
	
	public function explodeMovie($movieNode)
	{
		$node = $movieNode->item(0);
		$enfants = $node->childNodes;	
		$titre='';
		$description='';
		$acteur='';
		$realisateur='';
		$date = '';
		foreach($enfants as $enfant) // On prend chaque n�ud enfant s�par�ment
		{
			$nom = $enfant->nodeName; // On prend le nom de chaque n�ud
						
			if ($nom == 'title')
			{
				$titre = $enfant->nodeValue;
			}
			else if ($nom == 'description')
			{
				$description = $enfant->nodeValue;
			}	
			else if ($nom == 'actor')
			{
				$acteur = $enfant->nodeValue;
			}
			else if ($nom == 'director')
			{
				$realisateur = $enfant->nodeValue;
			}
			else if ($nom == 'date')
			{
				$date = $enfant->nodeValue;
			}			
		}
		return array('searchMovie' => true, 'title' => $titre, 'description' => $description, 'actors' => $acteur, 'directors' => $realisateur, 'date' => $date);
	
	}
	
	public function printListMovies($movies)
	{		
		for ($i = 0; $i < $movies->length; $i++) {
			echo $movies->item($i)->nodeValue . "\n";
			echo "<br />";
		}
	}
	











	public function testDom()
	{
		//Cr�ation d'un DomDocument
		$document_xml = new DomDocument(); 
		$document_xml->load('arbre.xml');

		//Creation d'un DOMXPath, pour faire des requetes XPath
		$dx = new DOMXPath($document_xml);
		$result = $dx->query('//puce');

		for ($i = 0; $i < $result->length; $i++) {
			echo $result->item($i)->nodeValue . "\n";
			echo "<br />";
		}



		//Parcourir tout le DomDocument recursivement
		$elements = $document_xml->getElementsByTagName('zcode');
		$element = $elements->item(0); // On obtient le n�ud zcode
		$this->rec($element);

		return $document_xml;

	}

	public function rec($node){
		$enfants = $node->childNodes;	
		foreach($enfants as $enfant) // On prend chaque n�ud enfant s�par�ment
		{
			$nom = $enfant->nodeName; // On prend le nom de chaque n�ud
						
			if ($nom == '#text')
			{
				$var = $enfant->nodeValue;
				echo $var;
			}
			else
			{
				$this->rec($enfant);
			}
		}
	}

	public function saveXML($domDocument){
		//On cr�e un nouveau noeud
		$element = $domDocument->createElement('newNoeud', '6');
		
		//On r�cup�re le noeud zcode
		$elements = $domDocument->getElementsByTagName('zcode');
		$zcode = $elements->item(0);
		
		//On ajoute notre �l�ment newNoeud a zcode
		$zcode->appendChild($element);
		
		$domDocument->save('arbreBis.xml');


	}
}