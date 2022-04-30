<?php
require('fpdf.php');

class PDF extends FPDF
{
    function header(){
        $this->Image('img/logo_propulse.png',10,6);
        $this->setFont('helvetica','B',14);
        $this->Cell(276,5,'TABLEAU DE RECLAMATION',0,0,'C');
        $this->Ln();
        $this->SetFont('Times','',12);
        $this->Cell(276,10,'Des produits de la lonaci',0,0,'C');
    }

    function footer(){
        $this->SetY(-15);
        $this->SetFont('helvetica','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function headerTable(){
        $this->SetY(85);
        $this->SetFont('Times','B',12);
        $this->Cell(20,10,'Produit',1.0,'C');
        $this->Cell(40,10,'Description',1.0,'C');
        $this->Cell(40,10,'statut',1.0,'C');
        $this->Ln();

    }

    function viewTable($db){
        session_start();
        require('inc/db.php');
        $this->SetFont('Times','',12);
        $sql = $pdo->query("SELECT support.id,support.description, support.statut,support.image,users.username as user ,produits.libelle as 'produit' FROM support LEFT OUTER JOIN produits ON produits.id = support.produit LEFT OUTER JOIN users ON users.id = support.user ORDER by support.id DESC");
       while($data = $sql->fetch(PDO::FETCH_OBJ)){
        //$_SESSION['support'] = $row;
        $hidden = false;
        $this->Cell(20,10,$data->produits,1,0,'C');
        $this->Cell(40,10,$data->Description,1,0,'C');
        $this->Cell(40,10,$data->statut,1,0,'C');
        $this->Ln();

        }
    }

}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->headerTable();
$pdf->viewTable($db);
$pdf->Output();
?>