<?php
namespace FH\Bundle\PostcodeApiNuBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @param $postalCode
     * @param $number
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findAddressAction($postalCode, $number)
    {
        try
        {
            $data = $this->get('postcode_api_nu.service')->find($postalCode, $number);

            return new Response(json_encode($data), 200, array('Content-type' => 'text/json'));
        } catch (\RuntimeException $e) {
            return new Response($e->getMessage(), 503);
        }
    }
}