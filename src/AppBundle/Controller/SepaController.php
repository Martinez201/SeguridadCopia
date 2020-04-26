<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Factura;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Security("is_granted('ROLE_GESTOR')")
 */


class SepaController extends Controller
{

    /**
     * @Route("/factura/sepa/{id}", name="sepa_generar")
     */
 public function acccion(Factura $factura){

     $encoders =[ new XmlEncoder()];
     $normalizers = [new ObjectNormalizer()];
     $serializer = new Serializer($normalizers,$encoders);

     $cliente = $factura->getCliente();
     $fechaEmisionDocumento =  new DateTime();
     $aux1 = new DateTime();
     $fechalimitePago = $aux1->add(date_interval_create_from_date_string('6 days'))->format('d-m-Y');
     $aux2 = $fechaEmisionDocumento->format('d-m-Y');
     $datosBancariosCliente = $cliente->getDatosBancarios();


     $documento = new Document();

    //cabecera
     $GrpHdr = new GrpHdr();

     $InitgPty = new InitgPty();

     //cuerpo
     $PmtInf = new PmtInf();

     $PmtTpInf = new PmtTpInf();
     $Dbtr = new Dbtr();
     $PstlAdr = new PstlAdr();
     $DbtrAcct = new DbtrAcct();
     $DbtrAgt = new DbtrAgt();
     $UltmtDbtr = new UltmtDbtr();
     $PmtId = new PmtId();
     $Amt = new Amt();
     $CdtrAgt = new CdtrAgt();
     $Cdtr = new Cdtr();
     $CdtrAcct = new CdtrAcct();
     $UltmtCdtr = new UltmtCdtr();

    //cabecera
     $GrpHdr->setMsId("ABC/060928/CCT001"); //DEJARLO
     $GrpHdr->setCreDtTm($factura->getFecha()->format('d-m-Y')); //PONER FECHA FACTURA
     $GrpHdr->setNbOfTxs(1); // DEJARLO
     $GrpHdr->setCtrlSum($factura->getPrecioConIva()); // CANTIDAD A COBRAR FACTURA

    //cabecera
     $InitgPty->setId('0468651441'); // DEJARLO
     $InitgPty->setIssr('KBO-BCE');//DEJARLO
     $InitgPty->setNm('ROBCO SECURITY S.A.U'); // NOMBRE DE LA EMPRESA QUE FACTURA

    //cuerpo
     $PmtInf->setPmtInfId('ABC/4560/'.$aux2); //CAMBIAR LA FECHA POR LA ACTUAL DEJAR EL RESTO DE LA CADENA
     $PmtInf->setPmtMtd('TRF'); // DEJARLO
     $PmtInf->setBtchBookg(false); // DEJARLO
     $PmtInf->setNbOfTxs(1); // NUMERO DE TRANSACCIONES (DEJARLO)
     $PmtInf->setCtrlSum($factura->getPrecioConIva()); // TOTAL A COBRAR FACTURA
     $PmtInf->setPmtTpInf($PmtTpInf);
     $PmtInf->setReqdExctnDt($fechalimitePago); // FECHA LIMITE DE PAGO FECHA EMISION FACTURA + 6 DIAS
     $PmtInf->setDbtr($Dbtr);
     $PmtInf->setDbtrAcct($DbtrAcct);
     $PmtInf->setUltmtDbtr($UltmtDbtr);
     $PmtInf->setChrgBr('SLEV');// DEJARLO
     $PmtInf->setPmtId($PmtId);
     $PmtInf->setAmt($Amt);
     $PmtInf->setCdtrAgt($CdtrAgt);
     $PmtInf->setCdtr($Cdtr);
     $PmtInf->setCdtrAcct($CdtrAcct);
     $PmtInf->setUltmtCdtr($UltmtCdtr);
     $PmtInf->setPurp('GDDS'); // DEJARLO


     $PmtTpInf->setInstrPrty('HIGH'); //DEJARLO
     $PmtTpInf->setSvclvl('SEPA'); //DEJARLO
     $PmtTpInf->setLclInstrm('TRF'); //DEJARLO
     $PmtTpInf->setCtgyPurp('SUPP'); //DEJARLO


     $Dbtr->setNm($cliente->getNombre()." ".$cliente->getApellidos()); // NOMBRE DEL CLIENTE
     $Dbtr->setPstlAdr($PstlAdr);

     $PstlAdr->setPstCd($cliente->getCPostal()); // CODIGO POSTAL CLIENTE
     $PstlAdr->setTwnNm($cliente->getCiudad()); // CIUDAD CLIENTE
     $PstlAdr->setCtry('España'); //PAIS DEL CLIENTE
     $PstlAdr->setAdrLine($cliente->getDireccion()." ". $cliente->getCiudad()." (".$cliente->getProvincia(). " )"); // DIRECCION DEL CLIENTE


     $DbtrAcct->setCcy('EUR'); // MONEDA DEL CLIENTE
     $DbtrAcct->setIBAN($datosBancariosCliente->getIban()); // IBAN DE LA CUENTA DEL CLIENTE

     $DbtrAgt->setBIC($datosBancariosCliente->getBic()); // BIC DE LA CUENTA DEL CLIENTE

     $UltmtDbtr->setNm('X'); // NOMBRE  ultimo Acreedor
     $UltmtDbtr->setId('X'); //ID ultimo acreedor

     $PmtId->setInstrId('265052/007/'.$aux2); // CAMBIAR LA FECHA DEJAR EL RESTO

     $Amt->setInstdAmt($factura->getPrecioConIva());

     $CdtrAgt->setBic('AIBKIE2D'); // BIC DE LA CUENTA DEL ACREEDOR

     $PstlAdr = new PstlAdr();
     $Cdtr->setNm('RobCo Security'); // ACREEDOR
     $Cdtr->setId('0468651441'); //ID ACREEDOR

     $PstlAdr->setPstCd('28080'); //CODIGO POSTAL ACREEDOR
     $PstlAdr->setTwnNm('Madrid'); // CIUDAD ACREEDOR
     $PstlAdr->setCtry('España'); //PAIS ACREEDOR
     $PstlAdr->setAdrLine('Avenida de Andalucía 128 (Edificio Tesla)'); //DIRECCION ACREEDOR

     $Cdtr->setPstlAdr($PstlAdr);

     $CdtrAcct->setIban('ES660020961234567890'); // IBAN ACREEDOR

     $UltmtCdtr->setId('X');
     $UltmtCdtr->setNum('XXX');


     //cabecera
     $GrpHdr->setInitgPty($InitgPty);

     $documento->setGrpHdr($GrpHdr); //cabecera documento xml
     $documento->setPmtInf($PmtInf); //Cuerpo transacciones

     /// AQUI ES DONDE SE CREA LA CADENA CON LA ESTRUCTURA DEL DOCUMENTO SEPA

     $resultado = $serializer->serialize($documento,'xml');

     //PROCESO DE DESCARGA DEL FICHERO XML

     $nombreFichero = 'DocumentoSepaCliente'.$cliente->getId().'.xml';

     $response = new Response($resultado);
    $response->headers->set('Content-Type','application/xml');
     $disposicion = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT,$nombreFichero);

     $response->headers->set('Content-Disposition',$disposicion);




     return $response;


 }



}


class Document
{
    private $GrpHdr;
    private $PmtInf;

    public function getGrpHdr(){

        return $this->GrpHdr;

    }
    public function setGrpHdr( $GrpHdr){

        $this->GrpHdr = $GrpHdr;

    }

    public function getPmtInf()
    {
        return $this->PmtInf;
    }


    public function setPmtInf($PmtInf)
    {
        $this->PmtInf = $PmtInf;
    }


}

class GrpHdr
{
    private $MsId;
    private $CreDtTm;
    private $NbOfTxs;
    private $InitgPty;
    private $CtrlSum;


    public function getMsId()
    {
        return $this->MsId;
    }


    public function setMsId($MsId)
    {
        $this->MsId = $MsId;
    }


    public function getCreDtTm()
    {
        return $this->CreDtTm;
    }


    public function setCreDtTm($CreDtTm)
    {
        $this->CreDtTm = $CreDtTm;
    }


    public function getNbOfTxs()
    {
        return $this->NbOfTxs;
    }


    public function setNbOfTxs($NbOfTxs)
    {
        $this->NbOfTxs = $NbOfTxs;
    }


    public function getInitgPty()
    {
        return $this->InitgPty;
    }


    public function setInitgPty($InitgPty)
    {
        $this->InitgPty = $InitgPty;
    }


    public function getCtrlSum()
    {
        return $this->CtrlSum;
    }


    public function setCtrlSum($CtrlSum)
    {
        $this->CtrlSum = $CtrlSum;
    }


}

class InitgPty
{
    private $Nm;
    private $Id;
    private $Issr;

    public function getNm()
    {
        return $this->Nm;
    }


    public function setNm($Nm)
    {
        $this->Nm = $Nm;
    }


    public function getId()
    {
        return $this->Id;
    }


    public function setId($Id)
    {
        $this->Id = $Id;
    }

    public function getIssr()
    {
        return $this->Issr;
    }


    public function setIssr($Issr)
    {
        $this->Issr = $Issr;
    }


}

class PmtInf
{
    private $PmtInfId;
    private $PmtMtd;
    private $BtchBookg;
    private $NbOfTxs;
    private $CtrlSum;
    private $PmtTpInf;
    private $ReqdExctnDt;
    private $Dbtr;
    private $DbtrAcct;
    private $DbtrAgt;
    private $UltmtDbtr;
    private $ChrgBr;
    private $PmtId;
    private $Amt;
    private $CdtrAgt;
    private $Cdtr;
    private $CdtrAcct;
    private $UltmtCdtr;
    private $Purp;


    public function getPmtInfId()
    {
        return $this->PmtInfId;
    }


    public function setPmtInfId($PmtInfId)
    {
        $this->PmtInfId = $PmtInfId;
    }


    public function getPmtMtd()
    {
        return $this->PmtMtd;
    }


    public function setPmtMtd($PmtMtd)
    {
        $this->PmtMtd = $PmtMtd;
    }


    public function getBtchBookg()
    {
        return $this->BtchBookg;
    }


    public function setBtchBookg($BtchBookg)
    {
        $this->BtchBookg = $BtchBookg;
    }


    public function getNbOfTxs()
    {
        return $this->NbOfTxs;
    }



    public function setNbOfTxs($NbOfTxs)
    {
        $this->NbOfTxs = $NbOfTxs;
    }


    public function getCtrlSum()
    {
        return $this->CtrlSum;
    }


    public function setCtrlSum($CtrlSum)
    {
        $this->CtrlSum = $CtrlSum;
    }


    public function getPmtTpInf()
    {
        return $this->PmtTpInf;
    }


    public function setPmtTpInf($PmtTpInf)
    {
        $this->PmtTpInf = $PmtTpInf;
    }


    public function getReqdExctnDt()
    {
        return $this->ReqdExctnDt;
    }

    public function setReqdExctnDt($ReqdExctnDt)
    {
        $this->ReqdExctnDt = $ReqdExctnDt;
    }


    public function getDbtr()
    {
        return $this->Dbtr;
    }


    public function setDbtr($Dbtr)
    {
        $this->Dbtr = $Dbtr;
    }


    public function getDbtrAcct()
    {
        return $this->DbtrAcct;
    }


    public function setDbtrAcct($DbtrAcct)
    {
        $this->DbtrAcct = $DbtrAcct;
    }


    public function getDbtrAgt()
    {
        return $this->DbtrAgt;
    }


    public function setDbtrAgt($DbtrAgt)
    {
        $this->DbtrAgt = $DbtrAgt;
    }


    public function getUltmtDbtr()
    {
        return $this->UltmtDbtr;
    }


    public function setUltmtDbtr($UltmtDbtr)
    {
        $this->UltmtDbtr = $UltmtDbtr;
    }


    public function getChrgBr()
    {
        return $this->ChrgBr;
    }


    public function setChrgBr($ChrgBr)
    {
        $this->ChrgBr = $ChrgBr;
    }


    public function getPmtId()
    {
        return $this->PmtId;
    }


    public function setPmtId($PmtId)
    {
        $this->PmtId = $PmtId;
    }


    public function getAmt()
    {
        return $this->Amt;
    }


    public function setAmt($Amt)
    {
        $this->Amt = $Amt;
    }


    public function getCdtrAgt()
    {
        return $this->CdtrAgt;
    }


    public function setCdtrAgt($CdtrAgt)
    {
        $this->CdtrAgt = $CdtrAgt;
    }


    public function getCdtr()
    {
        return $this->Cdtr;
    }


    public function setCdtr($Cdtr)
    {
        $this->Cdtr = $Cdtr;
    }


    public function getCdtrAcct()
    {
        return $this->CdtrAcct;
    }


    public function setCdtrAcct($CdtrAcct)
    {
        $this->CdtrAcct = $CdtrAcct;
    }


    public function getUltmtCdtr()
    {
        return $this->UltmtCdtr;
    }


    public function setUltmtCdtr($UltmtCdtr)
    {
        $this->UltmtCdtr = $UltmtCdtr;
    }



    public function getPurp()
    {
        return $this->Purp;
    }


    public function setPurp($Purp)
    {
        $this->Purp = $Purp;
    }

}

class PmtTpInf
{
    private $InstrPrty;
    private $LclInstrm;
    private $CtgyPurp;
    private $Svclvl;


    public function getInstrPrty()
    {
        return $this->InstrPrty;
    }


    public function setInstrPrty($InstrPrty)
    {
        $this->InstrPrty = $InstrPrty;
    }


    public function getLclInstrm()
    {
        return $this->LclInstrm;
    }


    public function setLclInstrm($LclInstrm)
    {
        $this->LclInstrm = $LclInstrm;
    }


    public function getCtgyPurp()
    {
        return $this->CtgyPurp;
    }


    public function setCtgyPurp($CtgyPurp)
    {
        $this->CtgyPurp = $CtgyPurp;
    }


    public function getSvclvl()
    {
        return $this->Svclvl;
    }


    public function setSvclvl($Svclvl)
    {
        $this->Svclvl = $Svclvl;
    }





}
class Dbtr
{
    private $Nm;
    private $PstlAdr;

    public function getNm()
    {
        return $this->Nm;
    }


    public function setNm($Nm)
    {
        $this->Nm = $Nm;
    }


    public function getPstlAdr()
    {
        return $this->PstlAdr;
    }


    public function setPstlAdr($PstlAdr)
    {
        $this->PstlAdr = $PstlAdr;
    }

}
class PstlAdr
{
    private $PstCd;
    private $TwnNm;
    private $Ctry;
    private $AdrLine;


    public function getPstCd()
    {
        return $this->PstCd;
    }


    public function setPstCd($PstCd)
    {
        $this->PstCd = $PstCd;
    }

    public function getTwnNm()
    {
        return $this->TwnNm;
    }


    public function setTwnNm($TwnNm)
    {
        $this->TwnNm = $TwnNm;
    }


    public function getCtry()
    {
        return $this->Ctry;
    }


    public function setCtry($Ctry)
    {
        $this->Ctry = $Ctry;
    }


    public function getAdrLine()
    {
        return $this->AdrLine;
    }


    public function setAdrLine($AdrLine)
    {
        $this->AdrLine = $AdrLine;
    }


}
class DbtrAcct
{
    private $IBAN;
    private $Ccy;


    public function getIBAN()
    {
        return $this->IBAN;
    }

    public function setIBAN($IBAN)
    {
        $this->IBAN = $IBAN;
    }


    public function getCcy()
    {
        return $this->Ccy;
    }


    public function setCcy($Ccy)
    {
        $this->Ccy = $Ccy;
    }


}
class DbtrAgt
{
    private $BIC;

    public function getBIC()
    {
        return $this->BIC;
    }


    public function setBIC($BIC)
    {
        $this->BIC = $BIC;
    }

}
class UltmtDbtr
{
    private $Nm;
    private $Id;


    public function getNm()
    {
        return $this->Nm;
    }


    public function setNm($Nm)
    {
        $this->Nm = $Nm;
    }


    public function getId()
    {
        return $this->Id;
    }


    public function setId($Id)
    {
        $this->Id = $Id;
    }


}
class PmtId
{

    public function getInstrId()
    {
        return $this->InstrId;
    }


    public function setInstrId($InstrId)
    {
        $this->InstrId = $InstrId;
    }

    private $InstrId;
}
class Amt
{
    private $InstdAmt;


    public function getInstdAmt()
    {
        return $this->InstdAmt;
    }


    public function setInstdAmt($InstdAmt)
    {
        $this->InstdAmt = $InstdAmt;
    } // pasa un objeto ==> ['Ccy="EUR"','#']


}
class CdtrAgt
{
    private $bic;


    public function getBic()
    {
        return $this->bic;
    }


    public function setBic($bic)
    {
        $this->bic = $bic;
    }


}
class Cdtr
{
    private $Nm;
    private $Id;
    private $PstlAdr;


    public function getNm()
    {
        return $this->Nm;
    }


    public function setNm($Nm)
    {
        $this->Nm = $Nm;
    }


    public function getId()
    {
        return $this->Id;
    }


    public function setId($Id)
    {
        $this->Id = $Id;
    }


    public function getPstlAdr()
    {
        return $this->PstlAdr;
    }


    public function setPstlAdr($PstlAdr)
    {
        $this->PstlAdr = $PstlAdr;
    }


}
class CdtrAcct
{
    private $iban;


    public function getIban()
    {
        return $this->iban;
    }


    public function setIban($iban)
    {
        $this->iban = $iban;
    }


}
class UltmtCdtr
{
    private $num;
    private $id;


    public function getNum()
    {
        return $this->num;
    }


    public function setNum($num)
    {
        $this->num = $num;
    }


    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

}

