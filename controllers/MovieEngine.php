<?php
class MovieEngine
{
	protected $movieTree;
	protected $XpathTree;
	
	public function __construct() // Constructeur demandant 2 paramètres
	{		
		$movieTree = $this->loadMovies();
		$XpathTree = $this->getXPathTree($movieTree);
		$result = $this->getMovieByName("lol",$XpathTree);
		$this->printListMovies($result);

	}
	
	public function loadMovies()
	{
		$document_xml = new DomDocument(); 
		$document_xml->load('./data/arbre.xml');
		return $document_xml;
	}
	
	public function getXPathTree($docXML)
	{
		return new DOMXPath($docXML);	
	}
	
	public function getMovieByName($name,$XpathTree)
	{
		$query = '//movie[title="'.$name.'"]';
		$result = $XpathTree->query($query);
		return $result;
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
		//Création d'un DomDocument
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
		$element = $elements->item(0); // On obtient le nœud zcode
		$this->rec($element);

		return $document_xml;

	}

	public function rec($node){
		$enfants = $node->childNodes;	
		foreach($enfants as $enfant) // On prend chaque nœud enfant séparément
		{
			$nom = $enfant->nodeName; // On prend le nom de chaque nœud
						
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
		//On crée un nouveau noeud
		$element = $domDocument->createElement('newNoeud', '6');
		
		//On récupère le noeud zcode
		$elements = $domDocument->getElementsByTagName('zcode');
		$zcode = $elements->item(0);
		
		//On ajoute notre élément newNoeud a zcode
		$zcode->appendChild($element);
		
		$domDocument->save('arbreBis.xml');


	}
}