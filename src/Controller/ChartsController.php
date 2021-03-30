<?php

namespace App\Controller;


use App\Entity\Competence;
use App\Entity\Enumerations\Categorie;
use BaseBundle\Entity\Enumerations\Topic;
use App\Entity\Users;
use DateTime;
use Doctrine\ORM\Query\Expr;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ChartsController extends AbstractController
{

    /**
     * @Route("/dashboard", name="dashboard")
     * @param Request $request

     */

    public function dashboard(Request $request)
    {
        return $this->render("base.html.twig");
    }


    /**
     * @Route("/chart_comp", name="chart_competence")
     * @param Request $request

     */

    public function chart_comp(Request $request)
    {
        $orm = $this->getDoctrine()->getManager();
        $repo = $orm->getRepository(Competence::class);

        $res = $repo->competenceByuser();

        $fixed_colors = ['#49A9EA','#36CAAB','#FF0000',"#ED6183","#ED6183"];
        $count = sizeof($fixed_colors);


        $labels = [];
        $data = [];
        $colors = [];

        foreach ($res as $i=>$r){
            $labels[]=$r["Titre"];
            $data[]=$r["1"];
            $index = $i % $count;
            $colors[]= $fixed_colors[$index];

        }

        $res= ["labels"=>$labels, "data"=>$data, "colors"=>$colors];

        return new JsonResponse($res);
    }

    /**
     * @Route("/chart_comp_1", name="chart_competence_1")
     * @param Request $request

     */

    public function chart1 (Request $request)
    {
        $orm = $this->getDoctrine()->getManager();
        $repo = $orm->getRepository(users::class);

        $res = $repo->UserByPays();

        $fixed_colors = ['#49A9EA','#36CAAB','#FF0000',"#ED6183","#ED6183"];
        $count = sizeof($fixed_colors);


        $labels = [];
        $data = [];
        $colors = [];

        foreach ($res as $i=>$r){
            $labels[]=$r["Pays"];
            $data[]=$r["1"];
            $index = $i % $count;
            $colors[]= $fixed_colors[$index];

        }

        $res= ["labels"=>$labels, "data"=>$data, "colors"=>$colors];

        return new JsonResponse($res);
    }
    /**
     * @Route("/chart3", name="chart_competence_3")
     * @param Request $request

     */

    public function chart3 (Request $request)
    {
        $orm = $this->getDoctrine()->getManager();
        $repo = $orm->getRepository(users::class);

        $res = $repo->UserBySexe();

        $fixed_colors = ['#f7b924','#6200EA','#FF0000',"#ED6183","#ED6183"];
        $count = sizeof($fixed_colors);


        $labels = [];
        $data = [];
        $colors = [];

        foreach ($res as $i=>$r){
            $labels[]=$r["Sexe"];
            $data[]=$r["1"];
            $index = $i % $count;
            $colors[]= $fixed_colors[$index];

        }

        $res= ["labels"=>$labels, "data"=>$data, "colors"=>$colors];

        return new JsonResponse($res);
    }

    /**
     * @Route("/chart2", name="chart_competence2")
     * @param Request $request

     */

    public function chart2 (Request $request)
    {
        $orm = $this->getDoctrine()->getManager();
        $repo = $orm->getRepository(users::class);

        $res = $repo->userByAge();

        $fixed_colors = ['#884DA7','#095228','#004365',"#ED6183","#ED6183"];
        $count = sizeof($fixed_colors);


        $labels = [];
        $data = [];
        $colors = [];

        foreach ($res as $i=>$r){
            $labels[]=$r["Age"];
            $data[]=$r["1"];
            $index = $i % $count;
            $colors[]= $fixed_colors[$index];

        }

        $res= ["labels"=>$labels, "data"=>$data, "colors"=>$colors];

        return new JsonResponse($res);
    }

    /**
     * @Route("/chart_comp_2", name="chart_competence_2")
     * @param Request $request

     */

    public function chart_comp_2(Request $request)
    {
        $orm = $this->getDoctrine()->getManager();
        $repo = $orm->getRepository(Competence::class);
        //************* code hne *********
        $array = ["labels"=>['Janvier','fevrier','Mars','Avril','Mai','Juin','Juillet','aout','septembre','octobre','Novembre','Decembre'], "data"=>[0,0,10]];
        return new JsonResponse($array);
    }



    /**
     * @Route("/business", name="admin_business_charts")
     */
    public function getBusinessChartsAction(){
        $o = $this->getMemberNumberChart();

        return $this->render('charts.html.twig', array(
            'chart' => $o['chart'],
            'cumulative' => $o['chart2'],
            'category' => $this->getBusinessByCategory()
        ));
    }

    private function containsMonth($counts, $month){
        foreach ($counts as $count){
            if($count['creation_month'] == $month)
                return $count;
        }
        return null;
    }

    private function getMemberNumberChart(){
        $months = array(
            0 => 'January',
            1 => 'February',
            2 => 'March',
            3 => 'April',
            4 => 'May',
            5 => 'June',
            6 => 'July',
            7 => 'August',
            8 => 'September',
            9 => 'October',
            10 => 'November',
            11 => 'December'
        );
        $counts = $this->getDoctrine()->getRepository(Users::class)->getBusinessCountByMonth();
        $tabs = array();
        $tabs2 = array();
        for($i=1; $i<=12; $i++){
            $count = $this->containsMonth($counts, $i);
            if($i==1){
                array_push($tabs2, (int)$count['total']);
            }else{
                array_push($tabs2, $tabs2[$i-2]+(int)$count['total']);
            }
            if ($count!=null){
                array_push($tabs, (int)$count['total']);
            }else{
                array_push($tabs, 0);
            }
        }
        $series = array(
            array("name" => "Business inscription number", "data" => $tabs)
        );
        $ob = new Highchart();
        $ob->chart->renderTo('linechart'); // #id du div où afficher le graphe
        $ob->title->text('Business Inscriptions number by month in '.(new DateTime)->format("Y"));
        $ob->xAxis->title(array('text' => "Months"));
        $ob->yAxis->title(array('text' => "Business inscriptions number"));
        $ob->xAxis->categories($months);
        $ob->series($series);


        $series2 = array(
            array("name" => "Business cumulative number", "data" => $tabs2)
        );
        $ob2 = new Highchart();
        $ob2->chart->renderTo('cumlinechart'); // #id du div où afficher le graphe
        $ob2->title->text('Business cumulative number in '.(new DateTime)->format("Y"));
        $ob2->xAxis->title(array('text' => "Months"));
        $ob2->yAxis->title(array('text' => "Business cumulative number"));
        $ob2->xAxis->categories($months);
        $ob2->series($series2);
        return ['chart' => $ob, 'chart2' => $ob2];
    }


    private function getBusinessByCategory(){
        $datas = $this->getDoctrine()->getRepository(Users::class)->getBusinessCountByCategory();

        $categories= array();
        $nbMembers=array();

        foreach($datas as $data) {
            array_push($competence,competence::getName($data['category']));
            array_push($nbMembers,(int)$data['total']);
        }
        $series = array(
            array(
                'name' => 'Businesses',
                'type' => 'column',
                'yAxis' => 0,
                'data' => $nbMembers,
            )
        );
        $yData = array(
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + "" }'),
                    'style' => array('color' => '#4572A7')
                ),
                'gridLineWidth' => 0,
                'title' => array(
                    'text' => 'Number of businesses',
                    'style' => array('color' => '#4572A7')
                ),
            ),
        );

        $ob = new Highchart();
        $ob->chart->renderTo('barchart'); // The #id of the divwhere to render the chart
        $ob->chart->type('column');
        $ob->title->text('Number of businesses by competence');
        $ob->xAxis->competence($competence);
        $ob->yAxis($yData);
        $ob->legend->enabled(false);
        /*$formatter = new Expr('function () {
            var unit = {
            "Member": "member(s)",
            }[this.series.name];

            return this.x + ": <b>" + this.y + "</b> " + unit;
        }');
        $ob->tooltip->formatter($formatter);*/
        $ob->series($series);

        return $ob;
    }
}
