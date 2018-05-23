<?php

namespace App\Controller;

use App\Entity\PM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class StatisticController
 * @package App\Controller
 * @Security("is_authenticated()")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class StatisticController extends Controller
{
    /**
     * @Route("/statistic", name="statistic")
     */
    public function index()
    {
        return $this->render('statistic/index.html.twig');
    }
	/**
	 * @Route("/statistic-json", options={"expose"=true} , name="statistic-json")
	 */
	public function statistic()
	{
		$em = $this->getDoctrine()->getManager();
		$artisan_by_gov = $em->getRepository(PM::class)->findArtisanGov();
		$artisan_by_activity = $em->getRepository(PM::class)->findArtisanActivity();
		$artisan_by_trades = $em->getRepository(PM::class)->findArtisanTrades();
		$artisan_by_activity_by_trades = $em->getRepository(PM::class)->findArtisanActivityTrades();
		$byDate = $em->getRepository(PM::class)->findByDate();

		return new JsonResponse( array(
			'artisan_by_gov' => $artisan_by_gov,
			'artisan_by_activity' => $artisan_by_activity,
			'artisan_by_trades' => $artisan_by_trades,
			'artisan_by_activity_by_trades' => $artisan_by_activity_by_trades,
			'byDate' => $byDate
		));
	}
}
