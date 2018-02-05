<?php
/**
 * Created by PhpStorm.
 * User: allse
 * Date: 25.01.2018
 * Time: 21:52
 */

class AdminOffersController extends AdminBase
{
    public function actionIndex($page=1)
    {
        $page=intval($page);

        self::checkAdmin();

        $total=Offer::getTotalOffersPublications();


        $offers=Offer::getListOffersPublications($page);

        if($page>intval($total/Joke::SHOW_BY_DEFAULT) )
            header('Location: /admin/show-offers/page-'.$page=intval($total/Joke::SHOW_BY_DEFAULT));


        $pagination=new Pagination($total,$page,Joke::SHOW_BY_DEFAULT,'page-');

        require_once (ROOT.'/view/admin/admin_offers.php');
        return true;
    }

    public function actionAccept($id)
    {
        self::checkAdmin();

        if(!isset($_POST['btn-accept'])){
            die('Access denied');
            exit();
        }

        $offer=Offer::getOfferInfoById($id);

        Joke::addPublication($offer);

        Offer::deleteOfferById($offer['id']);

        header('Location: /admin/show-offers');
        exit();
    }

    public function actionCancel($id)
    {
        self::checkAdmin();

        if(!isset($_POST['btn-cancel'])){
            die('Access denied');
            exit();
        }

        Offer::deleteOfferById($id);

        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }

}