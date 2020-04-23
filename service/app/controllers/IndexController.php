<?php
/**
 * 测试默认控制器
 * Created by ZhangDi.
 * User: Zhangdi
 * Date: 2018/1/2
 * Time: 14:53
 */

namespace App\Calculation\Controllers;


use App\Calculation\Services\BaZiService;
use App\Calculation\Services\BaZiYyService;
use App\Calculation\Services\BaZiZhService;
use App\Calculation\Services\CyxpService;
use App\Calculation\Services\HeHunService;
use App\Calculation\Services\SndyService;
use App\Calculation\Services\XmpdService;
use App\Calculation\Services\YinYuanCsService;
use App\Calculation\Validate\BaZiJpValidate;
use App\Calculation\Validate\BaZiYyValidate;
use App\Calculation\Validate\CyxpValidate;
use App\Calculation\Validate\HeHunValidate;
use App\Calculation\Validate\SndyValidate;
use App\Calculation\Validate\XmpdValidate;
use App\Calculation\Validate\YinYuanCsValidate;
use App\Calculation\Validate\IDMustBePostiveInt;
use App\Calculation\Validate\PayValidate;
use App\Calculation\Validate\TokenMustBeHave;
use Common\Models\Xmgl;


class IndexController extends BaseCalculationController
{
    private $money = 28;
    private $y_money = 88;

    private $hehun_money = 28;
    private $y_hehun_money = 88;

	protected $token;

	public function initialize(){
		// if(empty($this->token)){
            $token = (new TokenMustBeHave())->go_check();
			$this->token = $token;
        // }
	}

    public function indexAction(){

     //   header("HTTP/1.1 404 Not Found");exit;


        $name='张迪';
        $val = '张';
        $xing = '他塔喇';
        print_r(strlen($xing));
        $ming = mb_substr($xing,mb_strlen('他塔'));
        echo "<br/>";
        print_r($ming);
        $temp = preg_replace('/^'.$val.'/', '', $name);
        print_r($temp);die;
        //AOP
        $id = (new IDMustBePostiveInt())->go_check();

    }

    //获取名头网测名信息数据
    public function get_mingtouAction(){
        $curl = "http://www.mingtou.com/pingfen.php?u=send";
        $arr = [
            'name'=>'袁胜轩',
            'gender'=>'male'
        ];
        $res = $this -> curl_ragent($curl,$arr);
        var_dump($res);die;
    }

    /**
     * @desc    curl请求，变换请求浏览器类型、ip地址、来源网址
     * @date    2018-04-02 15:00:26
     * @param   [string $curlurl目标来源地址]
     * @author  1245049149@qq.com
     * @return  [string $page_content]
     */
    private function curl_ragent($curlurl='',$arr){
        header("Content-type:text/html;charset=utf-8");
//        $postdata = json_encode((object)$arr,JSON_UNESCAPED_UNICODE);
        $postdata = $arr;
        $ch = curl_init();
        $refer_url_array = [
            'tmall'  => 'https://www.tmall.com',
            'taobao' => 'https://www.taobao.com',
        ];
        $ip=mt_rand(11, 191).".".mt_rand(0, 240).".".mt_rand(1, 240).".".mt_rand(1, 240);   //随机ip
        $agent_array=[
            //PC端的UserAgent
            "safari 5.1 – MAC"=>"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11",
            "safari 5.1 – Windows"=>"Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50",
            "Firefox 38esr"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
            "IE 11"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; InfoPath.3; rv:11.0) like Gecko",
            "IE 9.0"=>"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0",
            "IE 8.0"=>"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
            "IE 7.0"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)",
            "IE 6.0"=>"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)",
            "Firefox 4.0.1 – MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Firefox 4.0.1 – Windows"=>"Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Opera 11.11 – MAC"=>"Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11",
            "Opera 11.11 – Windows"=>"Opera/9.80 (Windows NT 6.1; U; en) Presto/2.8.131 Version/11.11",
            "Chrome 17.0 – MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
            "傲游（Maxthon）"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Maxthon 2.0)",
            "腾讯TT"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; TencentTraveler 4.0)",
            "世界之窗（The World） 2.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
            "世界之窗（The World） 3.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; The World)",
            "360浏览器"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; 360SE)",
            "搜狗浏览器 1.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SE 2.X MetaSr 1.0; SE 2.X MetaSr 1.0; .NET CLR 2.0.50727; SE 2.X MetaSr 1.0)",
            "Avant"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Avant Browser)",
            "Green Browser"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
            //移动端口
            "safari iOS 4.33 – iPhone"=>"Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
            "safari iOS 4.33 – iPod Touch"=>"Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
            "safari iOS 4.33 – iPad"=>"Mozilla/5.0 (iPad; U; CPU OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
            "Android N1"=>"Mozilla/5.0 (Linux; U; Android 2.3.7; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Android QQ浏览器 For android"=>"MQQBrowser/26 Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn; MB200 Build/GRJ22; CyanogenMod-7) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Android Opera Mobile"=>"Opera/9.80 (Android 2.3.4; Linux; Opera Mobi/build-1107180945; U; en-GB) Presto/2.8.149 Version/11.10",
            "Android Pad Moto Xoom"=>"Mozilla/5.0 (Linux; U; Android 3.0; en-us; Xoom Build/HRI39) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13",
            "BlackBerry"=>"Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+",
            "WebOS HP Touchpad"=>"Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.0; U; en-US) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/233.70 Safari/534.6 TouchPad/1.0",
            "UC标准"=>"NOKIA5700/ UCWEB7.0.2.37/28/999",
            "UCOpenwave"=>"Openwave/ UCWEB7.0.2.37/28/999",
            "UC Opera"=>"Mozilla/4.0 (compatible; MSIE 6.0; ) Opera/UCWEB7.0.2.37/28/999",
            "微信内置浏览器"=>"Mozilla/5.0 (Linux; Android 6.0; 1503-M02 Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile MQQBrowser/6.2 TBS/036558 Safari/537.36 MicroMessenger/6.3.25.8　　　　　　　61 NetType/WIFI Language/zh_CN",
            "safari5.0"=>"Mozilla/5.0 (iPhone; U; CPU like Mac OS X) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/4A93 Safari/419.3",
            'google5.0' => 'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.27 Safari/525.13'

        ];
        $useragent= $agent_array['微信内置浏览器'];  //可设置随机浏览器：$agent_array[array_rand($agent_array,1)]；
        $referurl = $refer_url_array[array_rand($refer_url_array,1)];  //随机来源网址referurl
        $header = array(
            'CLIENT-IP:'.$ip,
            'X-FORWARDED-FOR:'.$ip,
        );    //构造ip
        curl_setopt($ch, CURLOPT_URL, $curlurl); //要抓取的网址
        curl_setopt($ch, CURLOPT_POST, 1);//POST请求
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_REFERER, $referurl);    //模拟来源网址
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent); //模拟常用浏览器的useragent
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //追踪页面重定向

        $page_content = curl_exec($ch);
        curl_close($ch);
        return $page_content;
    }

    /**
     * 八字合婚生成订单并测算
     */
    public function hehunAction(){

		header('Access-Control-Allow-Origin:*');

        $type = 2;//测算类型-八字合婚
        $data = (new HeHunValidate()) -> go_check();
        try{
            if(!isset($data['order_sn'])){

                if(!empty($data['boy_name'])) {
                    $xmgl = Xmgl::findFirst([
                        "conditions" => "fullname=:fullname:",
                        "bind" => ['fullname' => $data['boy_name']]
                    ]);
                    if ($xmgl) {
                        throw new \Exception('抱歉，本站无法处理您的请求！');
                    }
                }

                if(!empty($data['girl_name'])) {
                    $xmgl = Xmgl::findFirst([
                        "conditions" => "fullname=:fullname:",
                        "bind" => ['fullname' => $data['girl_name']]
                    ]);
                    if ($xmgl) {
                        throw new \Exception('抱歉，本站无法处理您的请求！');
                    }
                }


                //生成订单
                $money = $this->hehun_money;
                $y_money = $this -> y_hehun_money;

                $bdxcx = $this->post_params("bdxcx", "string", '');
                $order_sn = 'sm'. date('YmdHis').rand(10000, 99999).$bdxcx;

                $des = $data['boy_name'].'与'.$data['girl_name'].'的八字合婚';
                $data = array('boy_name'=>$data['boy_name'],'boy_year'=>$data['boy_year'],'boy_month'=>$data['boy_month'],'boy_day'=>$data['boy_day'],'boy_hour'=>$data['boy_hour'],'boy_fen'=>$data['boy_fen'],'girl_name'=>$data['girl_name'],'girl_year'=>$data['girl_year'],'girl_month'=>$data['girl_month'],'girl_day'=>$data['girl_day'],'girl_hour'=>$data['girl_hour'],'girl_fen'=>$data['girl_fen']);
                $datas = array('data'=>urlencode(json_encode($data)),'oid'=>$order_sn,'createtime'=>time(),'type'=>$type,'ip'=>\StringHelpers::get_real_ip(),'des'=>$des,'money'=>number_format($money,2),'open_id'=>$this->token);

                // 分销追踪
                $ad_code_id = $this->post_params("ad_code_id", "int", 0);
                $datas['ad_id'] =  $ad_code_id > 0 ?  $ad_code_id : 0;
                if($datas['ad_id'] > 0){
                    $ad_source = $this->post_params("ad_source", "int", 0);
                    \DistributorHelpers::insert($this->master_db, $datas['ad_id'], $order_sn, $money,  83, 2, $ad_source);
                }
                // End 分销

                //存入订单表
                (new \Yw11smorders()) -> insert_record($datas);
                $return_data=[
                    'order_sn'=>$order_sn,
                    'data'=>$data,
                    'des'=>$des,
                    'money'=>number_format($money,2),
                    'y_money'=>$y_money
                ];

                //将当前未支付订单数组数据存入redis
//                $datas['status'] = 0;//订单未支付
//                $datas['data'] = $data;
//                $redis_data[$order_sn] = $datas;
//                $this->save_order_redis($this->token,$redis_data);

                $this->return_format(1,'合婚订单生成成功',$return_data);
            }else{
                $row = (new \Yw11smorders())->get_record_by_oid($data['order_sn']);
                //获取免费标识--2019-5-23新增
                $is_free = $this -> post_params('is_free','remove_xss',0);
                if($row){
                    if($is_free==1){
                        $arr = json_decode(urldecode($row['data']),true);
                        $hehun_data = (new HeHunService())->hehun($arr);
                        //组装合婚文案信息[随机打乱]
                        $wenan_dsdp_arr[0] = "<p>{$hehun_data['name']}与{$hehun_data['name_a']}的八字五行互补性不强，如果你们已经是朋友，可通过后天的一些措施来补救。如工作行业、方位、颜色、饮食、兴趣、日常用品等。</p>
                        <p>{$hehun_data['name']}官杀强，{$hehun_data['name_a']}食伤强，十神关系上有互补，两人互相平衡，协调发展。</p>
                        <p>二位命卦组成'延年'，此为上等婚，可和睦相处，白头到老。(甲方命卦：坤二（西四命） 乙方命卦：乾六（西四命）)</p>
                        <p>二位属相没有特殊组合，配合情况一般。(女方属相：{$hehun_data['shengxiao2']} 男方属相：{$hehun_data['shengxiao1']})</p>";
                        $wenan_dsdp_arr[1] = "<p>{$hehun_data['name']}与{$hehun_data['name_a']}的五行八字尚佳，二人命卦互补性不强，为中上姻缘，婚姻偶有争执，但不会伤及情感，彼此需要多沟通，交流，方能让婚姻生活更加稳定。</p>
<p>{$hehun_data['name']}（男）伤官生财，聪明富有表现力，男命旺妻。{$hehun_data['name_a']}（女）命主清高，主观意识强，喜身旺，二人十神互补。</p>
<p>二人命宫相合，夫妻感情稳固，离婚的几率低。二人属相配合，婚配情况尚佳。</p>";
                        $wenan_dsdp_arr[2] = "<p>{$hehun_data['name']}与{$hehun_data['name_a']}的五行八字相合，二人命卦互补性，为天赐佳缘，两人性格互补，因此在日常生活的相处中，彼此都能感觉轻松惬意。</p>
<p>{$hehun_data['name']}（男）日柱逢禄神，禄神帮身、帮己，未来流年运势亨通。{$hehun_data['name_a']}（女）正印绶坐下，善良脾气好。命逢天德星，心地慈悲，乐善好施，平和，亲和力挺强，人缘都相对不错。两人可和睦相处，白头到老。</p>
二人命宫相合，夫妻相敬，紫气东来，福乐安详，家道昌隆。夫妻感情稳固，离婚的几率低。";
                        $wenan_dsdp_arr[3] = "<p>{$hehun_data['name']}与{$hehun_data['name_a']}的五行八字互补，二人命格相合卦组成“延年”，二人年柱纳音为佳配，此乃绨结良缘。两者相合能互补不足，相得益彰，夫妻情深意长。</p>
<p>{$hehun_data['name']}（男）年柱逢天乙，四柱有贵人，喜身旺，遇事有人帮，时运旺，贵不可言。{$hehun_data['name_a']}（女）坐伤官，干支金水相生，人秀丽聪明，但耿直，讲义气。两人性格相合，心心相惜，姻缘极佳。</p>
二人命宫相合，天做良缘，家道大着阵，财盛家宁，福碌永久，家运昌隆。夫妻感情稳固，离婚的几率低。";

                        $wenan_xg_arr[0] = "<p><b class='co_feffca'>{$hehun_data['name']}性格:</b></p>
                        <p>1、食神为喜用，为人聪明，温厚恭良，流露出精英秀气，秉性温和，不善与人争执，有长者风度，有文人学士的气质，乐天知命，重视精神与物质的协调，具有感性，对文学、艺术、 宗教等有爱好的趋势。（重点）</p>
                        <p>2、身坐库地，一生多忧少乐，即使富贵也不免孤独，平时言少有理，心慈性慢。（重点）</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}性格:</b></p>
                        <p>1、偏财遇伤官，为人多情，异性缘佳，应当妥善处理与异性关系，防患于未然。</p>
                        <p>2、女命带伤官，应谨慎择夫，不要重奢华虚荣。</p>
                        <p>3、女命日支正印为喜时，丈夫端庄厚重，仁慈善良，恭敬温和，忠厚稳重，和蔼可亲，乐观开朗，胸襟开阔。</p>";

                        $wenan_xg_arr[1] = "<p><b class='co_feffca'>{$hehun_data['name']}性格:</b></p>
                        <p>{$hehun_data['name']}生辰的命主，聪明儒雅，完美自信。为人敏感聪慧，文雅知性，有学者气质，XX日柱最喜伤官生财，多不食人间烟火。伤官无财，能说会道，聪明富有表现力，男命最佳，旺妻。行事温稳儒雅，爱面子。配偶大方多智喜相随。干支相生，文才好，可得妻财，或漂亮之妻。</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}性格:</b></p>
                        <p>{$hehun_data['name_a']}生辰的命主，精致聪明，主观意识强，有完美情节和自恋意识。主聪明秀气，自我表现欲望强，命主清高，心无旁骛，心志高，遇到困境喜独自承担，遍寻解决方法。喜身旺，固本培元。官独秀，多出奇才。</p>";

                        $wenan_xg_arr[2] = "<p><b class='co_feffca'>{$hehun_data['name']}性格:</b></p>
                        <p>{$hehun_data['name']}生辰的命主，伤官坐下。做事情开朗大方，显得更开明清高，不入俗流。伤官最喜冬生，暖局带着文明之象。喜欢追求浪漫、温暖的爱情，会花很多时间和精力在制造浪漫情调上，也时常给予对方惊喜，一起享受幸福爱情。同时也是个不拘小节的人，小事上随心所欲，一旦遇到大事，会同伴侣一起商讨对策，是一个靠得住的人。</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}性格:</b></p>
                        <p>{$hehun_data['name_a']}生辰的命主，大概都是乐天派，踏实沉稳，压力与危机感都比较小，总喜欢乐于情愿的好事情，喜欢想美事，而且乐得安逸，追求更加舒适的生活，事业冲动不多，缺乏紧迫感。心地善良，容易妥协，看不得人受苦。心软，容易被好话打动，生活当中待人真诚，不会主动生是非，属于多一事不如少一事的心态。平和安稳。配偶粗中有细，相辅相成。</p>";

                        $wenan_xg_arr[3] = "<p><b class='co_feffca'>{$hehun_data['name']}性格:</b></p>
                        <p>{$hehun_data['name']}生辰的命主，多才多艺，在艺术上表现出过人的天赋。明事理，不属于那种自我意识太重的类型。生活非常讲究，吃穿用度都非常注重品味和形象，但并不奢侈。婚姻美满，异性缘佳，对配偶有一定要求，必须有高雅的气质，以及善解人意的心肠。看起来温柔善良的邻家女孩，最能博得其青睐。</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}性格:</b></p>
                        <p>{$hehun_data['name_a']}生辰的命主，认真细致，中规中矩。主己土以阴制阳，刚柔有度。协调为主，刚毅不失妩媚。财星具备反制的功效，起监管和平衡的作用。因此命主必须面面俱到，做事低调，处世平和。具备得亦不喜，失亦不忧的中庸之象。喜欢就事论事，做一点成就一点，野心不大，心态乐观，易于满足。对周围人喜欢承担自己力所能及的事情，恩威有加，喜欢稳定泰然的生活。在婚姻中最是个好助手，事业心强的最适合与其婚配，能弥补自己的不足。</p>";

                        $wenan_mzzd_arr[0] = "<p>二人日柱纳音为吉配。二人时柱纳音为吉配。会有良好的婚姻基础。二位的前世缘分为'荣亲关系'，曾有一世的血缘关系，今世可成为好友。</p>
                        <p>若即若离的神秘感，加上适时体贴细腻的话语关怀，对你具有难以抗拒的吸引力。所以，如同童话故事美女与野兽，居住在城堡里的孤傲野兽，反而激起你试图一探对方内心世界的好奇心。</p>
                        <p>婚姻就是把爱情落实到生活里，睁开一只眼看清楚对方的优点，闭上一只眼无视对方的缺点。在婚姻中学着做个合适的人，而不是去找个合适的人。</p>";

                        $wenan_mzzd_arr[1] = "<p>二人年柱纳音为吉配，妻好婚配、子孙孝顺家业旺、六畜钱粮皆丰盈、一世富贵大吉昌。
前世曾有一世血缘，今生缘分得以再续。</p>
                        <p>日柱天干之五合，择偶的心性大多倾向于身体结实丰满，性格、外貌均朴实无华，忠诚孝顺，言行一致的人。</p>
                        <p>甲己合，这种天干之五合组成的家庭，多女人掌家权。择偶心性多倾向于身材高大，正直善良，举止大方而又清新高雅之人。</p>";

                        $wenan_mzzd_arr[2] = "<p>二人日柱、月柱纳音为吉配，夫妻好相配、高官禄位眼前风、两人合来无克害、儿女聪明永富贵。前世萍水相逢，有一面之缘，今生佳缘再续。</p>
                        <p>二人四命相异，年支不同气，夫妻间的机缘，需多了解彼此。多沟通建立彼此的信任与互动。</p>
                        <p>日干五行不相同，前世缘薄，今生难得相遇，所以需珍惜彼此的相遇。夫妻间情感并非一见钟情，通过相处，渐入佳境，两人都是慢热，日久生情之人，所以通过时间也能培养出感情。</p>";

                        $wenan_mzzd_arr[3] = "<p>二人年柱纳音极为相配，此乃绨结良缘，勤俭发家，日刡昌盛，子孙继世。前世为荣亲关系，今生可结良缘。</p>
                        <p>二人命宫相合，良缘佳偶，夫妻恩爱。两人的性格惺惺相惜，才华互相吸引。相同的人生观，更能加深彼此的感情。双方都有一致的思考方式和见解使彼此更加融洽。</p>
                        <p>日干五行相配，择偶心性多倾向于清新高雅，机智灵敏，积极进取之人。两人组成的家庭，夫妻之间能因有较好的和谐关系而幸福美满。</p>";

                        $wenan_hpzs_arr[0] = "<p><b class='co_feffca'>配婚分数：88分</b></p>
                        <p>{$hehun_data['name']}比劫强，{$hehun_data['name_a']}食伤强，十神关系上有互补，两人互相平衡，协调发展。二位命卦组成”五鬼，此为中等婚，根据合婚规律组合，双方可以在一起。</p>
                        <p>{$hehun_data['name']}：命卦：坎一（东四命）</p>
                        <p>{$hehun_data['name_a']}：命卦：中宫寄艮（西四命）</p>
                        <p>二位属相没有特殊组合，配合情况一般。二人月柱纳音为吉配。会有良好的婚姻基础。二位的前世缘分为共命之星”，有极多的共同点，一起投胎于同一地方，遭遇类似，为良好拍挡。二位出生的年月组合一般，但二人能和睦相处，互相促进。</p>";

                        $wenan_hpzs_arr[1] = "<p><b class='co_feffca'>配婚分数：92分</b></p>
                        <p>两人十神关系互补，互相平衡，协调发展。双方命卦相合，此为中上姻缘，婚姻情波折较小，日常生活虽为琐事相争，但无伤大雅。</p>
                        <p>{$hehun_data['name']}：命卦：坎一（东四命）</p>
                        <p>{$hehun_data['name_a']}：命卦：中宫寄艮（西四命）</p>
                        <p>两人属相组合尚可，生活中会有一些小摩擦，需互相沟通，协调，包容彼此，情感会愈加深厚。二人年柱纳音为吉配，如能和睦相处，相互促进，终能成就一段美好姻缘。</p>";

                        $wenan_hpzs_arr[2] = "<p><b class='co_feffca'>配婚分数：95分</b></p>
                        <p>两人命格关系互补，卦象相合，为天赐良缘，婚姻生活和谐，为上等婚配，婚姻情感顺，少波折，宜嫁娶。</p>
                        <p>{$hehun_data['name']}：命卦：坎一（东四命）</p>
                        <p>{$hehun_data['name_a']}：命卦：中宫寄艮（西四命）</p>
                        <p>两人属相相合，性格相近，为天作之合，情感会愈加深厚。二人年柱纳音为吉配，如能和睦相处，相互促进，终能成就一段美好姻缘。</p>";

                        $wenan_hpzs_arr[3] = "<p><b class='co_feffca'>配婚分数：100分</b></p>
                        <p>两人命格关系互补，卦象相合，为天赐良缘，婚姻生活和谐，为上等婚配，婚姻情感顺，少波折，宜嫁娶。</p>
                        <p>{$hehun_data['name']}：命卦：坎一（东四命）</p>
                        <p>{$hehun_data['name_a']}：命卦：中宫寄艮（西四命）</p>
                        <p>两人属相相合，性格心心相惜，为天作之合，情感会愈加深厚。二人年柱纳音为吉配，两人行为和思想步调一致，有相同的见解，彼此互相吸引，婚姻美满，令人羡慕。</p>";

                        $wenan_xfxw_arr[0] = "<p><b class='co_feffca'>{$hehun_data['name']}的婚姻</b></p>
                        <p>日支为忌神，对方素质赶不上本人。</p>
                        <p>四柱不见财星，以日支论妻。日支为忌神，对方不够贤惠。</p>
                        <p>日支偏印为忌时，对方轻浮草率，焦躁烦闷，嫉妒多疑。</p>
                        <p>月日支相刑或相冲，婚事不顺利或婚姻不顺，感情不和，易晚婚，早婚也不美满。</p>
                        <p>{$hehun_data['name']}的命财弱，适宜晚婚，否则于事业家庭方面发展壮大有阻碍。</p>
                        <p>日支受刑，适宜晚婚，否则于事业家庭有阻碍。</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}的婚姻</b></p>
                        <p>年日干支相同，婚姻不顺或不利配偶。</p>
                        <p>{$hehun_data['name_a']}的日支比肩为忌时，{$hehun_data['name']}则消极被动，草率马虎，意志薄弱，短视浅虑，我行我素。</p>
                        <p>食神太过，不见夫星，贞洁之妇。</p>
                        <p>食神得地利子。</p>
                        <p>您的配偶所在的方向(以您原籍住址为中心点)：东北方对西南方。</p>";

                        $wenan_xfxw_arr[1] = "<p><b class='co_feffca'>{$hehun_data['name']}的婚姻</b></p>
                        <p>四柱逢太极，命理带财星，命中福运亨通，时运丰隆，值此应当福气钟，更须贵格来相扶。
中正蓄藏，不愁木盛，不畏水狂，火少火晦，金多金光，若要物旺，宜助宜帮。
配偶外貌气质佳，善良勤奋善理财，但占有欲强。
您的配偶所在的方向(以您原籍住址为中心点)：西南方</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}的婚姻</b></p>
                        <p>命带天已，四柱有贵人，遇事有人帮，遇危难之事有人解救，是逢凶化吉之相。
欺霜侮雪，能锻庚金，逢辛反怯，土众成慈，水猖显节，虎马犬乡，甲来焚灭。
身坐正官，一权在握，往往自以为是，独裁固执。
您的配偶所在的方向(以您原籍住址为中心点)：东北方</p>";

                        $wenan_xfxw_arr[2] = "<p><b class='co_feffca'>{$hehun_data['name']}的婚姻</b></p>
                        <p>日柱逢禄神，禄神帮身、帮己，未来流年运势亨通。一生之中贵人多，关键的时候总有人助一臂之力，在事业和婚姻上都比较顺遂。其贵人、际遇、机会都往往比一般人的要多。坐正财，得贤妻，因妻制富，主高贵。
既中且正，静合动辟，万物司令，水润则生，物燥则病，若在艮坤，怕冲宜静。
欣赏处世成熟，作风踏实的女性；擅於理财，懂得规划未来者，更能吸引你的青睐。
您的配偶所在的方向(以您原籍住址为中心点)：东南方</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}的婚姻</b></p>
                        <p>正印绶坐下，善良脾气好。命逢天德星，心地慈悲，乐善好施，喜欢做一些热心肠的事情。平和，亲和力挺强，人缘都相对不错。
剖羊解牛，怀丁抱丙，跨凤乘猴，虚湿之地，骑马亦忧，藤罗系甲，可春可秋。
能干、心慈，命带财气。配偶多智多才干有财。对方稳定踏实的性格，能带给你可靠的安全感。
您的配偶所在的方向(以您原籍住址为中心点)：正西方</p>";

                        $wenan_xfxw_arr[3] = "<p><b class='co_feffca'>{$hehun_data['name']}的婚姻</b></p>
                        <p>年柱逢天乙，四柱有贵人，喜身旺，遇事有人帮，遇危难之事有人解救，是逢凶化吉之兆。遇生旺，则形貌轩昂，性灵颖悟，理义分明，所至之处，一切凶杀隐然而避。
刚健为最，得水而清，得火而锐，土润则生，土乾则脆，能造甲兄，输於乙妹
你欣赏反应机伶，伶牙俐齿的异性。性格倔强，甚至带点叛逆的女性，对你来说，最具魅力。
您的配偶所在的方向(以您原籍住址为中心点)：正北方</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}的婚姻</b></p>
                        <p>坐伤官，干支金水相生，人秀丽聪明，但耿直，讲义气。性格平和，文静，富有爱心。在生活当中，对金钱意识不强，适合稳定职业。
甲木参天，脱胎要火，春不容金，秋不容土，火炽成龙，水荡骑虎。
在人群中出尽锋头的异性，尤其能够吸引你的目光与青睐。所以，在生活中带给你许多惊喜您的配偶能令你心动。
所在的方向(以您原籍住址为中心点)：正南方</p>";

                        $wenan_tcdj_arr[0] = "<p>注：两人均是婚姻不利因素较大之人，最好把夫妇年龄拉大或晚婚为宜。</p>
                        <p>如婚前多经历几次恋爱，可以排泄不良之婚姻，有助于对异性的深刻认识，稳定日后的婚姻。</p>
                        <p>聚少离多也有助于淡化不良婚姻之影响。最重要的是要能忍让。</p>
                        <p>建议二位可以在生活上做一些五行互补，增强双方之间的感情，根据{{allData.name}}的五行，建议佩戴一些黑色饰品，用以提升感情质量，或者二位共同佩戴一些成双成对的饰品也可。</p>";

                        $wenan_tcdj_arr[1] = "<p>由于两个人都有鲜明的个性，并且都很倔强，所以相处中免不了小打小闹。保持良好关系的最佳途径是以赞美的目光注视对方，用甜蜜的话语彼此交流。你开朗冲动而富于激情，积极进取对生活充满热情。两个人具有相当的头脑，能力上没有太大的落差，都非常独立，不会甘心依附于对方。如果你们能够深入沟通，彼此了解对方的真正需要并能取得一致的话，你们将会非常幸福。</p>";

                        $wenan_tcdj_arr[2] = "<p>双方在性格上互补，能彼此成就一段佳缘。男方为人人沉稳，不善言辞，但是却非常可靠，让人非常放心。女方谨慎小心，安全感不强，男方恰好能够带来安定。女方对未来有很强的预知能力，做事深思熟虑，将生活安排的仅仅有条，这也恰恰是彼此最喜欢的生活节奏。女方性格坦率、活泼开朗，积极乐观，能够谈笑风生，能给彼此方带来不少的快乐，一静一动，性格互补，自然家庭和谐圆满。";

                        $wenan_tcdj_arr[3] = "<p>你们在一起，婚姻会非常稳固，是非常好的伴侣，你们能为了家庭全力以赴，遇事不服输，负责到底。男方财运上，容易有意想不到的收获，但是花钱大手大脚，而女方温情、并且富有主见，他们做事情都会后路，更善于理财，对爱人帮助非常大。女方性情温和，需要时刻有一个性格坚强、干练的人在旁提点，更能发挥自己的才能。而男方硬派的做事态度，能够改善其优柔寡断、犹豫不决的性格特点。</p>";

                        $wenan_mlxx_arr[0] = "<p>综合分析二位八字合婚可以划分为中等婚姻，双方在一起务必要收敛自己的不足之地，例如{$hehun_data['name']}比劫重，注意性格要多克制，否则也会引起感情危机。</p>
                        <p>两位八字地支中均隐藏食神，爱背地里评点他人，说别人的秘密，要防止因交往不慎重而泄露。最重要的是双方均有婚后出轨倾向。</p>";

                        $wenan_mlxx_arr[1] = "<p>综合分析二人的婚姻属于中上等婚姻，一方独立，要强，天生属于领导型人物，他们非常自信，对生活有追求，并且愿意为之奋斗，这点，深得对方青睐。另一人性格正直，喜欢享受美好的生活，追求品味，喜欢舒适的环境，在彼此方身上，都能得到满足。你们冲动，做事激进，莽撞，有时也容易因性格误事，而稳重，坦诚性格的人，能对其有诸多提点与帮扶，在对方遇到挫折的时候，能成为坚实的后盾。</p>";

                        $wenan_mlxx_arr[2] = "<p>综合分析二人的婚姻属于上层婚配，彼此为良配，二人在性格和气质上能够互相吸引，秉性纯良，对待彼此温柔有礼，对家庭都有高度的责任感，相同的三观和相近的性格，让两人感情越相处越来越好，夫妻生活越来越甜蜜。彼此对感情的忠贞，让对方成为此生最信赖的人。宁静美好的日子让双方在这段婚姻中能获得高度的满足感。</p>";

                        $wenan_mlxx_arr[3] = "<p>两个人都开朗大方，富于活力，你们的结合能使双方更加进一步地通力合作，从而拥有一个充满欢乐气氛的家庭。另一半聪明敏锐、富于情趣并很有洞察力，具备从容不迫的气质，慎独而淡泊名利，处事有条不紊。你真诚正直、善良直率，现实却很有包容心。对方理智的头脑、风趣的气质令你倾心不已。双方能够互相理解，互通心意，夫妻恩爱有佳，情感深厚。</p>";

                        $wenan_zntb_arr[0] = "<p>双方命局子女信息，属于同步状态，儿孙满堂晚年享受儿孙之福。</p>
                        <p><b class='co_feffca'>婚姻格言：</b></p>
                        <p>婚姻就是把爱情落实到生活里，睁开一只眼看清楚对方的优点，闭上一只眼无视对方的缺点。在婚姻中学着做个合适的人，而不是去找个合适的人。</p>
                        <p>夫妻相处之道是重视及感谢对方所做的一切，不要凡事视为当然。</p>
                        <p>能有智慧'建立一个温馨美满家庭'的人，才算是一个真正成功的人。</p>
                        <p>没有100分的另一半，只有50分的两个人。</p>";

                        $wenan_zntb_arr[1] = "<p>子女星当中坐天乙、月德，有贵人相助，双方命局子女信息同步，子女缘深厚，能享儿孙之福，后代身体方面都会比较健康，才华横溢。</p>
                        <p><b class='co_feffca'>婚姻格言：</b></p>
                        <p>每一份爱都有保质期，长短则取决于我们是否经营好婚姻。贴心的伴侣不会舍得让感情慢慢浪费。</p>
                        <p>婚姻就像是投资理财，投出的本金越多，付出越多，得到的回报就越丰厚。如果不付出，很可能竹篮打水一场空。</p>";

                        $wenan_zntb_arr[2] = "<p>双方子女星为喜用，子女能够给家庭带来福报，在刚步入婚姻的时候，财运平平，待到子女出生，家庭财运和夫妻事业会迎来较大转机。后代都是相当的有才能的人，也比较聪明，是能在人群当中脱颖而出的一类人才。</p>
                        <p><b class='co_feffca'>婚姻格言：</b></p>
                        <p>如果想充实自己，实现自己的梦想，一定要取得另一半的支持，并且鼓励对方与自己一起进步。只有保持二人平衡，不使差距太大，才能长久地维持这段关系。</p>
                        ";

                        $wenan_zntb_arr[3] = "<p>男命官杀为喜用，女命食伤喜用，双方命局带帝旺，虽然前半生辛苦操劳，了生计奔波不停，为了家人一直可能付出很多，但是这一切都很值得。夫妻双方能将子女能教育得很好，后代未来非富即贵。夫妻情深意长，家庭和谐美满，子女享福。</p>
                        <p><b class='co_feffca'>婚姻格言：</b></p>
                        <p>爱情需要合理的内容，正像熊熊烈火要油来维持一样；爱情是两个相似的天性在无限感觉中的和谐的交融。</p>
                        ";

                        $redis_key = 'cesuan_old_' . $row['id'];
                        if($this->redisModel->exists($redis_key) && $this->redisModel->ttl($redis_key) > 0){
                            $key = $this->redisModel->get($redis_key);
                            $hehun_data['test_info'] =  $row['id'].'-'.$key.'-1';
                        }else{
                            $key = array_rand($wenan_dsdp_arr,1);
                            $this->redisModel->set($redis_key, $key, 86400*30); // 保存一个月
                            $hehun_data['test_info'] =  $row['id'].'-'.$key.'-0';
                        }

                        //返回随机数组键名
                        //$rand_key = array_rand($wenan_dsdp_arr,1);

                        //将当前订单数组数据存入redis当前用户生成的文案信息存入
                        $row['type'] = $this->get_action($row['type']);
                        $hehun_data['wenan_dsdp_arr'] = $wenan_dsdp_arr[$key];
                        $hehun_data['wenan_xg_arr'] = $wenan_xg_arr[$key];
                        $hehun_data['wenan_mzzd_arr'] = $wenan_mzzd_arr[$key];
                        $hehun_data['wenan_hpzs_arr'] = $wenan_hpzs_arr[$key];
                        $hehun_data['wenan_xfxw_arr'] = $wenan_xfxw_arr[$key];
                        $hehun_data['wenan_tcdj_arr'] = $wenan_tcdj_arr[$key];
                        $hehun_data['wenan_mlxx_arr'] = $wenan_mlxx_arr[$key];
                        $hehun_data['wenan_zntb_arr'] = $wenan_zntb_arr[$key];

                        //$redis_data[$data['order_sn']] = $row;
                        //$this->save_order_redis($this->token,$redis_data);

                        $this->return_format(1,'测算成功',$hehun_data);
                    }
                    if($row['status']!=1){
                        $this->return_format(10001,'该订单未支付',[]);
                    }else{
                        $arr = json_decode(urldecode($row['data']),true);
                        $hehun_data = (new HeHunService())->hehun($arr);
                        //组装合婚文案信息[随机打乱]
                        $wenan_dsdp_arr[0] = "<p>{$hehun_data['name']}与{$hehun_data['name_a']}的八字五行互补性不强，如果你们已经是朋友，可通过后天的一些措施来补救。如工作行业、方位、颜色、饮食、兴趣、日常用品等。</p>
                        <p>{$hehun_data['name']}官杀强，{$hehun_data['name_a']}食伤强，十神关系上有互补，两人互相平衡，协调发展。</p>
                        <p>二位命卦组成'延年'，此为上等婚，可和睦相处，白头到老。(甲方命卦：坤二（西四命） 乙方命卦：乾六（西四命）)</p>
                        <p>二位属相没有特殊组合，配合情况一般。(女方属相：{$hehun_data['shengxiao2']} 男方属相：{$hehun_data['shengxiao1']})</p>";
                        $wenan_dsdp_arr[1] = "<p>{$hehun_data['name']}与{$hehun_data['name_a']}的五行八字尚佳，二人命卦互补性不强，为中上姻缘，婚姻偶有争执，但不会伤及情感，彼此需要多沟通，交流，方能让婚姻生活更加稳定。</p>
<p>{$hehun_data['name']}（男）伤官生财，聪明富有表现力，男命旺妻。{$hehun_data['name_a']}（女）命主清高，主观意识强，喜身旺，二人十神互补。</p>
<p>二人命宫相合，夫妻感情稳固，离婚的几率低。二人属相配合，婚配情况尚佳。</p>";
                        $wenan_dsdp_arr[2] = "<p>{$hehun_data['name']}与{$hehun_data['name_a']}的五行八字相合，二人命卦互补性，为天赐佳缘，两人性格互补，因此在日常生活的相处中，彼此都能感觉轻松惬意。</p>
<p>{$hehun_data['name']}（男）日柱逢禄神，禄神帮身、帮己，未来流年运势亨通。{$hehun_data['name_a']}（女）正印绶坐下，善良脾气好。命逢天德星，心地慈悲，乐善好施，平和，亲和力挺强，人缘都相对不错。两人可和睦相处，白头到老。</p>
二人命宫相合，夫妻相敬，紫气东来，福乐安详，家道昌隆。夫妻感情稳固，离婚的几率低。";
                        $wenan_dsdp_arr[3] = "<p>{$hehun_data['name']}与{$hehun_data['name_a']}的五行八字互补，二人命格相合卦组成“延年”，二人年柱纳音为佳配，此乃绨结良缘。两者相合能互补不足，相得益彰，夫妻情深意长。</p>
<p>{$hehun_data['name']}（男）年柱逢天乙，四柱有贵人，喜身旺，遇事有人帮，时运旺，贵不可言。{$hehun_data['name_a']}（女）坐伤官，干支金水相生，人秀丽聪明，但耿直，讲义气。两人性格相合，心心相惜，姻缘极佳。</p>
二人命宫相合，天做良缘，家道大着阵，财盛家宁，福碌永久，家运昌隆。夫妻感情稳固，离婚的几率低。";

                        $wenan_xg_arr[0] = "<p><b class='co_feffca'>{$hehun_data['name']}性格:</b></p>
                        <p>1、食神为喜用，为人聪明，温厚恭良，流露出精英秀气，秉性温和，不善与人争执，有长者风度，有文人学士的气质，乐天知命，重视精神与物质的协调，具有感性，对文学、艺术、 宗教等有爱好的趋势。（重点）</p>
                        <p>2、身坐库地，一生多忧少乐，即使富贵也不免孤独，平时言少有理，心慈性慢。（重点）</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}性格:</b></p>
                        <p>1、偏财遇伤官，为人多情，异性缘佳，应当妥善处理与异性关系，防患于未然。</p>
                        <p>2、女命带伤官，应谨慎择夫，不要重奢华虚荣。</p>
                        <p>3、女命日支正印为喜时，丈夫端庄厚重，仁慈善良，恭敬温和，忠厚稳重，和蔼可亲，乐观开朗，胸襟开阔。</p>";

                        $wenan_xg_arr[1] = "<p><b class='co_feffca'>{$hehun_data['name']}性格:</b></p>
                        <p>{$hehun_data['name']}生辰的命主，聪明儒雅，完美自信。为人敏感聪慧，文雅知性，有学者气质，XX日柱最喜伤官生财，多不食人间烟火。伤官无财，能说会道，聪明富有表现力，男命最佳，旺妻。行事温稳儒雅，爱面子。配偶大方多智喜相随。干支相生，文才好，可得妻财，或漂亮之妻。</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}性格:</b></p>
                        <p>{$hehun_data['name_a']}生辰的命主，精致聪明，主观意识强，有完美情节和自恋意识。主聪明秀气，自我表现欲望强，命主清高，心无旁骛，心志高，遇到困境喜独自承担，遍寻解决方法。喜身旺，固本培元。官独秀，多出奇才。</p>";

                        $wenan_xg_arr[2] = "<p><b class='co_feffca'>{$hehun_data['name']}性格:</b></p>
                        <p>{$hehun_data['name']}生辰的命主，伤官坐下。做事情开朗大方，显得更开明清高，不入俗流。伤官最喜冬生，暖局带着文明之象。喜欢追求浪漫、温暖的爱情，会花很多时间和精力在制造浪漫情调上，也时常给予对方惊喜，一起享受幸福爱情。同时也是个不拘小节的人，小事上随心所欲，一旦遇到大事，会同伴侣一起商讨对策，是一个靠得住的人。</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}性格:</b></p>
                        <p>{$hehun_data['name_a']}生辰的命主，大概都是乐天派，踏实沉稳，压力与危机感都比较小，总喜欢乐于情愿的好事情，喜欢想美事，而且乐得安逸，追求更加舒适的生活，事业冲动不多，缺乏紧迫感。心地善良，容易妥协，看不得人受苦。心软，容易被好话打动，生活当中待人真诚，不会主动生是非，属于多一事不如少一事的心态。平和安稳。配偶粗中有细，相辅相成。</p>";

                        $wenan_xg_arr[3] = "<p><b class='co_feffca'>{$hehun_data['name']}性格:</b></p>
                        <p>{$hehun_data['name']}生辰的命主，多才多艺，在艺术上表现出过人的天赋。明事理，不属于那种自我意识太重的类型。生活非常讲究，吃穿用度都非常注重品味和形象，但并不奢侈。婚姻美满，异性缘佳，对配偶有一定要求，必须有高雅的气质，以及善解人意的心肠。看起来温柔善良的邻家女孩，最能博得其青睐。</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}性格:</b></p>
                        <p>{$hehun_data['name_a']}生辰的命主，认真细致，中规中矩。主己土以阴制阳，刚柔有度。协调为主，刚毅不失妩媚。财星具备反制的功效，起监管和平衡的作用。因此命主必须面面俱到，做事低调，处世平和。具备得亦不喜，失亦不忧的中庸之象。喜欢就事论事，做一点成就一点，野心不大，心态乐观，易于满足。对周围人喜欢承担自己力所能及的事情，恩威有加，喜欢稳定泰然的生活。在婚姻中最是个好助手，事业心强的最适合与其婚配，能弥补自己的不足。</p>";

                        $wenan_mzzd_arr[0] = "<p>二人日柱纳音为吉配。二人时柱纳音为吉配。会有良好的婚姻基础。二位的前世缘分为'荣亲关系'，曾有一世的血缘关系，今世可成为好友。</p>
                        <p>若即若离的神秘感，加上适时体贴细腻的话语关怀，对你具有难以抗拒的吸引力。所以，如同童话故事美女与野兽，居住在城堡里的孤傲野兽，反而激起你试图一探对方内心世界的好奇心。</p>
                        <p>婚姻就是把爱情落实到生活里，睁开一只眼看清楚对方的优点，闭上一只眼无视对方的缺点。在婚姻中学着做个合适的人，而不是去找个合适的人。</p>";

                        $wenan_mzzd_arr[1] = "<p>二人年柱纳音为吉配，妻好婚配、子孙孝顺家业旺、六畜钱粮皆丰盈、一世富贵大吉昌。
前世曾有一世血缘，今生缘分得以再续。</p>
                        <p>日柱天干之五合，择偶的心性大多倾向于身体结实丰满，性格、外貌均朴实无华，忠诚孝顺，言行一致的人。</p>
                        <p>甲己合，这种天干之五合组成的家庭，多女人掌家权。择偶心性多倾向于身材高大，正直善良，举止大方而又清新高雅之人。</p>";

                        $wenan_mzzd_arr[2] = "<p>二人日柱、月柱纳音为吉配，夫妻好相配、高官禄位眼前风、两人合来无克害、儿女聪明永富贵。前世萍水相逢，有一面之缘，今生佳缘再续。</p>
                        <p>二人四命相异，年支不同气，夫妻间的机缘，需多了解彼此。多沟通建立彼此的信任与互动。</p>
                        <p>日干五行不相同，前世缘薄，今生难得相遇，所以需珍惜彼此的相遇。夫妻间情感并非一见钟情，通过相处，渐入佳境，两人都是慢热，日久生情之人，所以通过时间也能培养出感情。</p>";

                        $wenan_mzzd_arr[3] = "<p>二人年柱纳音极为相配，此乃绨结良缘，勤俭发家，日刡昌盛，子孙继世。前世为荣亲关系，今生可结良缘。</p>
                        <p>二人命宫相合，良缘佳偶，夫妻恩爱。两人的性格惺惺相惜，才华互相吸引。相同的人生观，更能加深彼此的感情。双方都有一致的思考方式和见解使彼此更加融洽。</p>
                        <p>日干五行相配，择偶心性多倾向于清新高雅，机智灵敏，积极进取之人。两人组成的家庭，夫妻之间能因有较好的和谐关系而幸福美满。</p>";

                        $wenan_hpzs_arr[0] = "<p><b class='co_feffca'>配婚分数：88分</b></p>
                        <p>{$hehun_data['name']}比劫强，{$hehun_data['name_a']}食伤强，十神关系上有互补，两人互相平衡，协调发展。二位命卦组成”五鬼，此为中等婚，根据合婚规律组合，双方可以在一起。</p>
                        <p>{$hehun_data['name']}：命卦：坎一（东四命）</p>
                        <p>{$hehun_data['name_a']}：命卦：中宫寄艮（西四命）</p>
                        <p>二位属相没有特殊组合，配合情况一般。二人月柱纳音为吉配。会有良好的婚姻基础。二位的前世缘分为共命之星”，有极多的共同点，一起投胎于同一地方，遭遇类似，为良好拍挡。二位出生的年月组合一般，但二人能和睦相处，互相促进。</p>";

                        $wenan_hpzs_arr[1] = "<p><b class='co_feffca'>配婚分数：92分</b></p>
                        <p>两人十神关系互补，互相平衡，协调发展。双方命卦相合，此为中上姻缘，婚姻情波折较小，日常生活虽为琐事相争，但无伤大雅。</p>
                        <p>{$hehun_data['name']}：命卦：坎一（东四命）</p>
                        <p>{$hehun_data['name_a']}：命卦：中宫寄艮（西四命）</p>
                        <p>两人属相组合尚可，生活中会有一些小摩擦，需互相沟通，协调，包容彼此，情感会愈加深厚。二人年柱纳音为吉配，如能和睦相处，相互促进，终能成就一段美好姻缘。</p>";

                        $wenan_hpzs_arr[2] = "<p><b class='co_feffca'>配婚分数：95分</b></p>
                        <p>两人命格关系互补，卦象相合，为天赐良缘，婚姻生活和谐，为上等婚配，婚姻情感顺，少波折，宜嫁娶。</p>
                        <p>{$hehun_data['name']}：命卦：坎一（东四命）</p>
                        <p>{$hehun_data['name_a']}：命卦：中宫寄艮（西四命）</p>
                        <p>两人属相相合，性格相近，为天作之合，情感会愈加深厚。二人年柱纳音为吉配，如能和睦相处，相互促进，终能成就一段美好姻缘。</p>";

                        $wenan_hpzs_arr[3] = "<p><b class='co_feffca'>配婚分数：100分</b></p>
                        <p>两人命格关系互补，卦象相合，为天赐良缘，婚姻生活和谐，为上等婚配，婚姻情感顺，少波折，宜嫁娶。</p>
                        <p>{$hehun_data['name']}：命卦：坎一（东四命）</p>
                        <p>{$hehun_data['name_a']}：命卦：中宫寄艮（西四命）</p>
                        <p>两人属相相合，性格心心相惜，为天作之合，情感会愈加深厚。二人年柱纳音为吉配，两人行为和思想步调一致，有相同的见解，彼此互相吸引，婚姻美满，令人羡慕。</p>";

                        $wenan_xfxw_arr[0] = "<p><b class='co_feffca'>{$hehun_data['name']}的婚姻</b></p>
                        <p>日支为忌神，对方素质赶不上本人。</p>
                        <p>四柱不见财星，以日支论妻。日支为忌神，对方不够贤惠。</p>
                        <p>日支偏印为忌时，对方轻浮草率，焦躁烦闷，嫉妒多疑。</p>
                        <p>月日支相刑或相冲，婚事不顺利或婚姻不顺，感情不和，易晚婚，早婚也不美满。</p>
                        <p>{$hehun_data['name']}的命财弱，适宜晚婚，否则于事业家庭方面发展壮大有阻碍。</p>
                        <p>日支受刑，适宜晚婚，否则于事业家庭有阻碍。</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}的婚姻</b></p>
                        <p>年日干支相同，婚姻不顺或不利配偶。</p>
                        <p>{$hehun_data['name_a']}的日支比肩为忌时，{$hehun_data['name']}则消极被动，草率马虎，意志薄弱，短视浅虑，我行我素。</p>
                        <p>食神太过，不见夫星，贞洁之妇。</p>
                        <p>食神得地利子。</p>
                        <p>您的配偶所在的方向(以您原籍住址为中心点)：东北方对西南方。</p>";

                        $wenan_xfxw_arr[1] = "<p><b class='co_feffca'>{$hehun_data['name']}的婚姻</b></p>
                        <p>四柱逢太极，命理带财星，命中福运亨通，时运丰隆，值此应当福气钟，更须贵格来相扶。
中正蓄藏，不愁木盛，不畏水狂，火少火晦，金多金光，若要物旺，宜助宜帮。
配偶外貌气质佳，善良勤奋善理财，但占有欲强。
您的配偶所在的方向(以您原籍住址为中心点)：西南方</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}的婚姻</b></p>
                        <p>命带天已，四柱有贵人，遇事有人帮，遇危难之事有人解救，是逢凶化吉之相。
欺霜侮雪，能锻庚金，逢辛反怯，土众成慈，水猖显节，虎马犬乡，甲来焚灭。
身坐正官，一权在握，往往自以为是，独裁固执。
您的配偶所在的方向(以您原籍住址为中心点)：东北方</p>";

                        $wenan_xfxw_arr[2] = "<p><b class='co_feffca'>{$hehun_data['name']}的婚姻</b></p>
                        <p>日柱逢禄神，禄神帮身、帮己，未来流年运势亨通。一生之中贵人多，关键的时候总有人助一臂之力，在事业和婚姻上都比较顺遂。其贵人、际遇、机会都往往比一般人的要多。坐正财，得贤妻，因妻制富，主高贵。
既中且正，静合动辟，万物司令，水润则生，物燥则病，若在艮坤，怕冲宜静。
欣赏处世成熟，作风踏实的女性；擅於理财，懂得规划未来者，更能吸引你的青睐。
您的配偶所在的方向(以您原籍住址为中心点)：东南方</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}的婚姻</b></p>
                        <p>正印绶坐下，善良脾气好。命逢天德星，心地慈悲，乐善好施，喜欢做一些热心肠的事情。平和，亲和力挺强，人缘都相对不错。
剖羊解牛，怀丁抱丙，跨凤乘猴，虚湿之地，骑马亦忧，藤罗系甲，可春可秋。
能干、心慈，命带财气。配偶多智多才干有财。对方稳定踏实的性格，能带给你可靠的安全感。
您的配偶所在的方向(以您原籍住址为中心点)：正西方</p>";

                        $wenan_xfxw_arr[3] = "<p><b class='co_feffca'>{$hehun_data['name']}的婚姻</b></p>
                        <p>年柱逢天乙，四柱有贵人，喜身旺，遇事有人帮，遇危难之事有人解救，是逢凶化吉之兆。遇生旺，则形貌轩昂，性灵颖悟，理义分明，所至之处，一切凶杀隐然而避。
刚健为最，得水而清，得火而锐，土润则生，土乾则脆，能造甲兄，输於乙妹
你欣赏反应机伶，伶牙俐齿的异性。性格倔强，甚至带点叛逆的女性，对你来说，最具魅力。
您的配偶所在的方向(以您原籍住址为中心点)：正北方</p>
                        <p><b class='co_feffca'>{$hehun_data['name_a']}的婚姻</b></p>
                        <p>坐伤官，干支金水相生，人秀丽聪明，但耿直，讲义气。性格平和，文静，富有爱心。在生活当中，对金钱意识不强，适合稳定职业。
甲木参天，脱胎要火，春不容金，秋不容土，火炽成龙，水荡骑虎。
在人群中出尽锋头的异性，尤其能够吸引你的目光与青睐。所以，在生活中带给你许多惊喜您的配偶能令你心动。
所在的方向(以您原籍住址为中心点)：正南方</p>";

                        $wenan_tcdj_arr[0] = "<p>注：两人均是婚姻不利因素较大之人，最好把夫妇年龄拉大或晚婚为宜。</p>
                        <p>如婚前多经历几次恋爱，可以排泄不良之婚姻，有助于对异性的深刻认识，稳定日后的婚姻。</p>
                        <p>聚少离多也有助于淡化不良婚姻之影响。最重要的是要能忍让。</p>
                        <p>建议二位可以在生活上做一些五行互补，增强双方之间的感情，根据{{allData.name}}的五行，建议佩戴一些黑色饰品，用以提升感情质量，或者二位共同佩戴一些成双成对的饰品也可。</p>";

                        $wenan_tcdj_arr[1] = "<p>由于两个人都有鲜明的个性，并且都很倔强，所以相处中免不了小打小闹。保持良好关系的最佳途径是以赞美的目光注视对方，用甜蜜的话语彼此交流。你开朗冲动而富于激情，积极进取对生活充满热情。两个人具有相当的头脑，能力上没有太大的落差，都非常独立，不会甘心依附于对方。如果你们能够深入沟通，彼此了解对方的真正需要并能取得一致的话，你们将会非常幸福。</p>";

                        $wenan_tcdj_arr[2] = "<p>双方在性格上互补，能彼此成就一段佳缘。男方为人人沉稳，不善言辞，但是却非常可靠，让人非常放心。女方谨慎小心，安全感不强，男方恰好能够带来安定。女方对未来有很强的预知能力，做事深思熟虑，将生活安排的仅仅有条，这也恰恰是彼此最喜欢的生活节奏。女方性格坦率、活泼开朗，积极乐观，能够谈笑风生，能给彼此方带来不少的快乐，一静一动，性格互补，自然家庭和谐圆满。";

                        $wenan_tcdj_arr[3] = "<p>你们在一起，婚姻会非常稳固，是非常好的伴侣，你们能为了家庭全力以赴，遇事不服输，负责到底。男方财运上，容易有意想不到的收获，但是花钱大手大脚，而女方温情、并且富有主见，他们做事情都会后路，更善于理财，对爱人帮助非常大。女方性情温和，需要时刻有一个性格坚强、干练的人在旁提点，更能发挥自己的才能。而男方硬派的做事态度，能够改善其优柔寡断、犹豫不决的性格特点。</p>";

                        $wenan_mlxx_arr[0] = "<p>综合分析二位八字合婚可以划分为中等婚姻，双方在一起务必要收敛自己的不足之地，例如{$hehun_data['name']}比劫重，注意性格要多克制，否则也会引起感情危机。</p>
                        <p>两位八字地支中均隐藏食神，爱背地里评点他人，说别人的秘密，要防止因交往不慎重而泄露。最重要的是双方均有婚后出轨倾向。</p>";

                        $wenan_mlxx_arr[1] = "<p>综合分析二人的婚姻属于中上等婚姻，一方独立，要强，天生属于领导型人物，他们非常自信，对生活有追求，并且愿意为之奋斗，这点，深得对方青睐。另一人性格正直，喜欢享受美好的生活，追求品味，喜欢舒适的环境，在彼此方身上，都能得到满足。你们冲动，做事激进，莽撞，有时也容易因性格误事，而稳重，坦诚性格的人，能对其有诸多提点与帮扶，在对方遇到挫折的时候，能成为坚实的后盾。</p>";

                        $wenan_mlxx_arr[2] = "<p>综合分析二人的婚姻属于上层婚配，彼此为良配，二人在性格和气质上能够互相吸引，秉性纯良，对待彼此温柔有礼，对家庭都有高度的责任感，相同的三观和相近的性格，让两人感情越相处越来越好，夫妻生活越来越甜蜜。彼此对感情的忠贞，让对方成为此生最信赖的人。宁静美好的日子让双方在这段婚姻中能获得高度的满足感。</p>";

                        $wenan_mlxx_arr[3] = "<p>两个人都开朗大方，富于活力，你们的结合能使双方更加进一步地通力合作，从而拥有一个充满欢乐气氛的家庭。另一半聪明敏锐、富于情趣并很有洞察力，具备从容不迫的气质，慎独而淡泊名利，处事有条不紊。你真诚正直、善良直率，现实却很有包容心。对方理智的头脑、风趣的气质令你倾心不已。双方能够互相理解，互通心意，夫妻恩爱有佳，情感深厚。</p>";

                        $wenan_zntb_arr[0] = "<p>双方命局子女信息，属于同步状态，儿孙满堂晚年享受儿孙之福。</p>
                        <p><b class='co_feffca'>婚姻格言：</b></p>
                        <p>婚姻就是把爱情落实到生活里，睁开一只眼看清楚对方的优点，闭上一只眼无视对方的缺点。在婚姻中学着做个合适的人，而不是去找个合适的人。</p>
                        <p>夫妻相处之道是重视及感谢对方所做的一切，不要凡事视为当然。</p>
                        <p>能有智慧'建立一个温馨美满家庭'的人，才算是一个真正成功的人。</p>
                        <p>没有100分的另一半，只有50分的两个人。</p>";

                        $wenan_zntb_arr[1] = "<p>子女星当中坐天乙、月德，有贵人相助，双方命局子女信息同步，子女缘深厚，能享儿孙之福，后代身体方面都会比较健康，才华横溢。</p>
                        <p><b class='co_feffca'>婚姻格言：</b></p>
                        <p>每一份爱都有保质期，长短则取决于我们是否经营好婚姻。贴心的伴侣不会舍得让感情慢慢浪费。</p>
                        <p>婚姻就像是投资理财，投出的本金越多，付出越多，得到的回报就越丰厚。如果不付出，很可能竹篮打水一场空。</p>";

                        $wenan_zntb_arr[2] = "<p>双方子女星为喜用，子女能够给家庭带来福报，在刚步入婚姻的时候，财运平平，待到子女出生，家庭财运和夫妻事业会迎来较大转机。后代都是相当的有才能的人，也比较聪明，是能在人群当中脱颖而出的一类人才。</p>
                        <p><b class='co_feffca'>婚姻格言：</b></p>
                        <p>如果想充实自己，实现自己的梦想，一定要取得另一半的支持，并且鼓励对方与自己一起进步。只有保持二人平衡，不使差距太大，才能长久地维持这段关系。</p>
                        ";

                        $wenan_zntb_arr[3] = "<p>男命官杀为喜用，女命食伤喜用，双方命局带帝旺，虽然前半生辛苦操劳，了生计奔波不停，为了家人一直可能付出很多，但是这一切都很值得。夫妻双方能将子女能教育得很好，后代未来非富即贵。夫妻情深意长，家庭和谐美满，子女享福。</p>
                        <p><b class='co_feffca'>婚姻格言：</b></p>
                        <p>爱情需要合理的内容，正像熊熊烈火要油来维持一样；爱情是两个相似的天性在无限感觉中的和谐的交融。</p>
                        ";

                        $redis_key = 'cesuan_old_' . $row['id'];

                        if($this->redisModel->exists($redis_key) && $this->redisModel->ttl($redis_key) > 0){
                            $key = $this->redisModel->get($redis_key);
                        }else{
                            $key = array_rand($wenan_dsdp_arr,1);
                            $this->redisModel->set($redis_key, $key, 86400*30); // 保存一个月
                        }
                        //返回随机数组键名
                        //$rand_key = array_rand($wenan_dsdp_arr,1);

                        //将当前订单数组数据存入redis当前用户生成的文案信息存入
                        $row['type'] = $this->get_action($row['type']);
                        $hehun_data['wenan_dsdp_arr'] = $wenan_dsdp_arr[$key];
                        $hehun_data['wenan_xg_arr'] = $wenan_xg_arr[$key];
                        $hehun_data['wenan_mzzd_arr'] = $wenan_mzzd_arr[$key];
                        $hehun_data['wenan_hpzs_arr'] = $wenan_hpzs_arr[$key];
                        $hehun_data['wenan_xfxw_arr'] = $wenan_xfxw_arr[$key];
                        $hehun_data['wenan_tcdj_arr'] = $wenan_tcdj_arr[$key];
                        $hehun_data['wenan_mlxx_arr'] = $wenan_mlxx_arr[$key];
                        $hehun_data['wenan_zntb_arr'] = $wenan_zntb_arr[$key];

                        //$redis_data[$data['order_sn']] = $row;
                        //$this->save_order_redis($this->token,$redis_data);

                        $this->return_format(1,'测算成功',$hehun_data);
                    }
                }else{
                    $this->return_format(10002,'订单不存在',[]);
                }
            }

        }catch (\Exception $e){
            $this->return_format(10004,$e -> getMessage());
        }
    }

    /**
     * 月老姻缘测算API
     */
    public function yinyuancsAction(){

		header('Access-Control-Allow-Origin:*');

        $type = 7;//测算类型-月老姻缘
        $data = (new YinYuanCsValidate()) -> go_check();
        try{
            if(!isset($data['order_sn'])){

                if(!empty($data['full_name'])) {
                    $xmgl = Xmgl::findFirst([
                        "conditions" => "fullname=:fullname:",
                        "bind" => ['fullname' => $data['full_name']]
                    ]);
                    if ($xmgl) {
                        throw new \Exception('抱歉，本站无法处理您的请求！');
                    }
                }

                //生成订单
                $money = $this->money;
                $y_money = $this -> y_money;
                $order_sn = date('YmdGis').time().rand(100, 999);
                $des = $data['full_name'].'的月老姻缘';
                $data = ['full_name'=>$data['full_name'],'sex'=>$data['sex'],'year'=>$data['year'],'month'=>$data['month'],'day'=>$data['day'],'hour'=>$data['hour'],'i'=>$data['i'],'c_year'=>$data['c_year'],'c_month'=>$data['c_month'],'c_day'=>$data['c_day'],'c_hour'=>$data['c_hour'],'term1'=>$data['term1'],'term2'=>$data['term2'],'start_term'=>$data['start_term'],'end_term'=>$data['end_term'],'start_term1'=>$data['start_term1'],'end_term1'=>$data['end_term1'],'lDate'=>$data['lDate']];
                $datas = array('data'=>urlencode(json_encode($data)),'oid'=>$order_sn,'createtime'=>time(),'type'=>$type,'ip'=>\StringHelpers::get_real_ip(),'des'=>$des,'money'=>number_format($money,2),'open_id'=>$this->token);

                // 分销追踪
                $ad_code_id = $this->post_params("ad_code_id", "int", 0);
                $datas['ad_id'] =  $ad_code_id > 0 ?  $ad_code_id : 0;
                if($datas['ad_id'] > 0){
                    $ad_source = $this->post_params("ad_source", "int", 0);
                    \DistributorHelpers::insert($this->master_db, $datas['ad_id'], $order_sn, $money,  82, 2, $ad_source);
                }
                // End 分销

                //存入订单表
                (new \Yw11smorders()) -> insert_record($datas);
                $return_data=[
                    'order_sn'=>$order_sn,
                    'data'=>$data,
                    'des'=>$des,
                    'money'=>number_format($money,2),
                    'y_money'=>$y_money
                ];

                $this->return_format(1,'月老姻缘订单生成成功',$return_data);
            }else{
                $row = (new \Yw11smorders())->get_record_by_oid($data['order_sn']);
                if($row){
                    if($row['status']!=1){
                        $this->return_format(10001,'该订单未支付',[]);
                    }else{
                        $arr = json_decode(urldecode($row['data']),true);
                        $yinyuancs_data = (new YinYuanCsService())->yinyuancs($arr);
                        $yuefen = (new YinYuanCsService())->yuefen($yinyuancs_data['user']['sx']);
                        $yinyuancs_data['sx']['yf'] = $yuefen;
                        $pp = (new BaZiService()) -> bazipp($arr);
                        $yinyuancs_data['pp'] = $pp;
                        //将当前订单数组数据存入redis
                        //组装
                        $wenan_poqk_arr[0] = "根据您的八字综合分析，您的配偶头部占身体的比例较大，五官轮廓突显，外型优雅，戴眼镜的比例很高，眼神清澈无邪，精力旺盛，笑容非常有魅力，能感染人。配偶性格亲切善良、人缘极佳，喜欢听别人倾诉，沟通力强。性格优柔寡断，不懂如何决定，喜欢逃避现实，犹豫不决，不知所措。具有别具一格的审美能力，拥有很好的社交能力。感情上稍有固执，喜欢追寻心中所想，主动求追异性的几率比较大。不善于安排物质生活，也不把钱放在心上，没有金钱观念，因此对恋人和朋友都比较大方。";
                        $wenan_poqk_arr[1] = "根据您的八字综合分析，您的配偶一般而言皮肤较白，容易晒黑，眼神机灵，略带狡黠。说话速度快，机智敏捷、反应快，自我意识与应变能力强。您的配偶为人非常热情，有着小孩子的一面，对新事物有极大的新鲜感和好奇心。性格非常有个性，一般都有自己独特的思想。是个比较直爽的人，藏不住话，需要什么，或者想要的，都会明确的表达出来。对困难的时候，具有坚韧不拔的精神，很坚强，哪怕在感情、生活上遇见挫折，也能马上调整自己的心态，重新找到新的希望。";
                        $wenan_poqk_arr[2] = "根据您的八字综合分析，您的配偶属于湿性体质，皮肤细致，胸部宽厚眼睛大而圆，嘴唇较宽厚，发质比较好。";
                        $wenan_poqk_arr[3] = "您的配偶向往自由的生活，对未知的事情充满了好奇心，即便是结了婚，有了孩子，也保持着活跃的心态，为人乐观，充满激情，感情也极为丰富，情绪波动比较大，丰富的情感也使得他们的生活绚丽多彩。喜欢自由、随性的生活，也有很强的主观性，凡事都有自己的想法和见解并且他人很难撼动他们的想法，一意孤行，我行我素是身上最明显的标签。在有了小孩以后也丝毫不会改掉自己叛逆的特点。";

                        $wenan_hyfm_arr[0] = "<p>注：婚姻感情方面不顺，易因此陡增烦恼。其不顺内容包括：晚婚、多恋不成、婚后不睦、分居、外遇、离婚、婚后一方多病等，应此则不应彼。</p>
                                <p class='p_t10'></p>
                                <p>婚姻不利因素较大之人，最好把夫妇年龄拉大或晚婚为宜。</p>
                                <p class='p_t10'></p>
                                <p>婚前多经历几次恋爱，可以排泄不良之婚姻，有助于对异性的深刻认识，稳定日后的婚姻。</p>
                                <p class='p_t10'></p>
                                <p>聚少离多也有助于淡化不良婚姻之影响。</p>
                                <p class='p_t10'></p>
                                <p>最重要的是要能忍让。</p>";
                        $wenan_hyfm_arr[1] = "<p>注：您在感情上遇到的问题很多，容出现波折，但是婚后生活会比较稳定。因此在婚前可以多接触不同的人，经历几次不同的恋情，晚婚为宜，婚姻情况会更好。</p>
                                <p class='p_t10'></p>
                                <p>您渴望美好的婚姻关系，对家庭的比较重视，希望婚姻能够长久的走下去，认定一个人就是一辈子，因此对另一半的包容心也比较足，只要不出现原则性的错误，都可以忍让。其实这并非是好事，婚姻是夫妻双方共同经营的，不是靠一个人就维持的好，建议适度，掌握分寸，如果是对方的问题，也需要坦白清楚。</p>
                                ";
                        $wenan_hyfm_arr[2] = "<p>注：您对婚姻的态度非常谨慎，并不急于成婚，因此通常会选择晚婚。您需要一段时间来考察对方是不是可以共同走向婚姻的人，也是对婚姻负责的一种表现。</p>
                                <p class='p_t10'></p>
                                <p>您对于婚姻关系看的比较现实，异常的谨慎，绝对不会让自己在婚姻中吃亏。</p>
                                <p class='p_t10'></p>
                                <p>在长时间的相处中恋人的脾气好坏是衡量你们感情关系中最重要的一环，除此之外，您也会从家庭出身、受教育程度、外貌等多方面考察对方。</p>
                                <p class='p_t10'></p>
                                <p>您的事业心很强，认为物质是婚姻中的保障，能带来安全感。有钱才能够让您感觉舒服和稳定。在结婚之前可能严格按照规划行事，而疏忽了恋人之间的相处，甚至忙于自己的事情而忽略对方的感受。但是结婚之后，这些猜疑都会迎刃而解。当然，在婚姻中还是建议，把自己的安排和计划告诉爱人，共同商议，这样也能提升彼此的亲密感和婚姻的幸福感。</p>
                                ";
                        $wenan_hyfm_arr[3] = "<p>注：您对家庭的责任感非常强，希望每一段恋情，都是奔着结婚的目的去的，对婚姻的期待指数非常高，一旦确定感情，就希望能开花结果，这也是对彼此恋情最好的交代。</p>
                                <p class='p_t10'></p>
                                <p>您对婚姻的质量要求非常高，不适合的对象，一定不会将就，绝对不会为了结婚而结婚。</p>
                                <p class='p_t10'></p>
                                <p>您的性格有强势的一面，而且非常独立，希望事业稳定了再考虑成家的事情，早年会全力拼搏事业，等时机成熟了，立马结婚，希望一切都按照计划进行。您其实是希望能够早婚，早点稳定下来的，但是对于婚姻的责任感让您在婚姻上还是决定放缓脚步，稳健发展。</p>
                                ";
                        $wenan_hyys_arr[0] = "命中官星比较旺，异性缘比较好，能多得异性帮助。但您的八字中官星离日干比较远，与配偶婚后感情会日益淡化、在八字中官星不宜太旺，也不宜官杀混杂，大都有感情困扰，要么是自命不凡，孤芳自赏，气傲性慢，刚柔失常，自寻烦恼！";
                        $wenan_hyys_arr[1] = "您八字中正官为喜用，但是官星离日干比较远，婚后生活总体平淡，没有波折，但是却缺少一些激情，时间久了让人感觉感情变淡了，但其实，是因为彼此越来越熟悉，习惯了对方的存在，无需太过焦虑。";
                        $wenan_hyys_arr[2] = "您的恋爱或结婚对象不太容易“一见钟情”，多半是需要经过相处，通过双方的互动，才有可能擦出爱的火花。最有可能是在一起共事的时候产生恋情，例如一起策划，一起开会，一起工作，一起讨论的时候，慢慢地产生的恋情。至于婚姻情况，您会把重心先放在事业成就上，因此您很有可能比较晚婚。若是您到现在，对象还没有出现，您身边共事的人中，最有默契，最有才干的那一位可能就是您的对象了，只要真心诚意去追求，幸福就在您身边。";
                        $wenan_hyys_arr[3] = "您对于心仪的异性，绝对会主动出击，虽然感觉很甜蜜，但不容易长久，常常半途而归，因为要从头到尾都维持相同的热情确实有点难。一般来说，异性对您的第一印象都会觉得很不错，尤其您又兼具追女朋友的魅力与手腕。但是随着交往时间越长，您的热情不再，冲劲不再，新鲜感不再。";

                        $wenan_hyjy_arr[0] = "从您的八字中总体分析结合最近几年的流年运判断，感情运势方面比较一般，但从八字中正官为喜用结合2019己亥年运，感情方面已经处于上升趋势、所以暂时感情运淡还请不要着急、另外你可以在卧室种植一些盆栽最好能开花的，卧室影响一个人的运势因素最大，所以提升卧室生机有利提升总体运势，鲜花象征的爱情、所以种植能开花的盆栽有助提升自身感情运，从而提高感情质量。";
                        $wenan_hyjy_arr[1] = "如果您在等待美好的爱情，您可以试着把自己的内在美透过各种方式表现出来，多参加各种活动，多培养各种兴趣，多接触不同人群，如此您会在不知不觉中，让您的内在美随时展现，爱情才会更顺利。如果您已经有家庭了，感情变淡也不需要着急，学会在生活中制造一些小惊喜与小浪漫，纪念日的时候给对方惊喜，慢慢找回当初热恋时的情感。";
                        $wenan_hyjy_arr[2] = "如果您在等待美好的爱情，您可以试着把自己的外在美收敛起来，让对方不是只因为看到您的外在美而跟您交往，而是要对方真心觉得适合您才跟您交往。如此之前的桃花都会烟消云散，而真正的爱情也将降临。";
                        $wenan_hyjy_arr[3] = "如果希望能够跟喜欢的人走向婚姻，建议您放慢追求的脚步，多去了解对方，真正的爱情是细水长流的，觉得对方真心合适，是自己希望共度一生的人，再进行下一步。如此也能避免掉很多情感上的烂桃花，让真正的爱情开花结果。";

                        $wenan_aqfx_arr[0] = "<p><b>桃花指数：</b>3颗星，TA外表好看，异性缘还不错</p>
                                <p class='p_t10'></p>
                                <p><b class='co_db3437'>桃花运：</b>也许对你而言，身边有没有异性都无所谓。现在的你，心里并没有特别烦恼或想不开的心事，所以对一切人事物都用一视同仁的心态对待。不管是同性或异性，都能跟你很愉快相处，不会有任何的压力。</p>
                                <p class='p_t10'></p>
                                <p><b>小贴士：</b>因为你一视同仁的心态对待他们，异性友人会觉得有距离感，建议你再遇到喜欢的对象时主动些，人总是要对自己的幸福把握好机会！</p>";

                        $wenan_aqfx_arr[1] = "<p><b>爱情运势：</b>4颗星，TA外表好看，异性缘还不错</p>
                                <p class='p_t10'></p>
                                <p><b class='co_db3437'>桃花运：</b>您对于心仪的异性，很容易心动，但不容易成功，常常无疾而终，因为要两个人都一见钟情确实有点难。经过深入的了解，对方会发现您的优点与内在美。换句话说，您很容易第一眼就喜欢上一个人，却不容易经过长时间相处而喜欢上一个人。相反地，您的恋爱对象不容易第一眼就喜欢上您，却很可能经过长时间相处而喜欢上您。</p>
                                <p class='p_t10'></p>
                                <p><b>小贴士：</b>因为你一视同仁的心态对待他们，异性友人会觉得有距离感，建议你再遇到喜欢的对象时主动些，人总是要对自己的幸福把握好机会！</p>";

                        $wenan_aqfx_arr[2] = "<p><b>桃花指数：</b>5颗星，TA外表好看，异性缘好</p>
                                <p class='p_t10'></p>
                                <p><b class='co_db3437'>桃花运：</b>一般来说，异性对您的第一印象都会觉得很不错，尤其您肯上进，又优秀，能力也强。但是随着交往时间越长，您的热情逐渐转移到了工作，爱情就容易降温。换句话说，您不容易第一眼就喜欢上一个人，却可能经过长时间后喜欢上一个人。相反地，您的恋爱对象很容易第一眼就喜欢上您，却很容易经过长时间后选择离开您，因为不愿意她的地位排在您的工作之后。</p>
                                ";

                        $wenan_aqfx_arr[3] = "<p><b>桃花指数：</b>5颗星，TA外表好看，异性缘非常好</p>
                                <p class='p_t10'></p>
                                <p><b class='co_db3437'>桃花运：</b>您渴望获得自己想要的那种爱情，为了爱情而不断努力，不断去改变自己。进入明年，命中开始逐渐迎来旺盛的桃花运，能够获得不错的情感运势，甚至有机会结束自己的单身生活。在明年，可以遇到各个方面条件都很合适的异性，去结识生活中工作上那些和自己有缘的异性，将有机会和对方确定恋爱关系。</p>
                                <p class='p_t10'></p>
                                <p><b>小贴士：</b>保持对于感情的耐心，不要因为出现一些意外变故就选择放弃爱情。只有经历过磨难的爱情才可以更为甜蜜。</p>";

                        $wenan_mdth_arr[0] = "<p>您命中有:红艳桃花2朵</p>
                                <p class='p_t10'></p>
                                <img src='images/hua01.png' align='left' style='width:.65rem;margin-right:.05rem;vertical-align: top;''>
                                <p class='f_s16 co_0000f5'>红艳桃花</p>
                                <p>高雅优美追求者众</p>
                                <p>顾名思义，红艳给人感受如同花开美好又灿烂，主众人见你心喜，本人气质出众，有特殊的魅力与好人缘，以至于本人在爱情追求上如虎添翼。红艳桃花，全名红艳桃花煞。命带红艳桃花，象征当事人外缘极佳，感情世界丰富。除了吸引异性欣赏，命带红艳桃花者，本身性情亦属浪漫多情，面对追求者示爱，很容易动情而接受对方。在你的八字格局里有红艳桃花，象征你发生一见锺情的机率很高，往往会在电石火光间遇到了那个对的人与恋人的发展关系往往是激情四射，当然这样的感情来得快也去得快。因为命带红艳桃花，象征本人异性缘佳，且生性多情。即使身旁已有交往对象，仍会吸引其他异性追求，若本身意志不坚，很容易就风流韵事不断，造成爱情运势不稳、感情容易生变。</p>";

                        $wenan_mdth_arr[1] = "<p>您命中有:红艳桃花3朵</p>
                                <p class='p_t10'></p>
                                <img src='images/hua01.png' align='left' style='width:.65rem;margin-right:.05rem;vertical-align: top;''>
                                <p class='f_s16 co_0000f5'>红艳桃花</p>
                                <p>您的恋爱或结婚对象很有可能是先经由亲友介绍或相亲而认识，因为您对于爱情比较不太有经验，也有时也会怯于表达自己的感情，碰到喜欢的人也多半停留在欣赏的阶段，不容易积极主动的展开追求，更不会死缠烂打，因此不仅错失许多机会，更在心中产生既期待又怕受伤害的感觉，反而更不容易擦出爱的火花。您若是对象还没有出现，不要心急，在您身边确定有人正喜欢着您，只要真心诚意去追求，一定会得到幸福的眷顾。</p>
                               ";

                        $wenan_mdth_arr[2] = "<p>您命中有:红艳桃花4朵</p>
                                <p class='p_t10'></p>
                                <img src='images/hua01.png' align='left' style='width:.65rem;margin-right:.05rem;vertical-align: top;''>
                                <p class='f_s16 co_0000f5'>红艳桃花</p>
                                <p>您渴望获得自己想要的那种爱情，为了爱情而不断努力，不断去改变自己。进入明年，命中开始逐渐迎来旺盛的桃花运，能够获得不错的情感运势，甚至有机会结束自己的单身生活。在明年，可以遇到各个方面条件都很合适的异性，去结识生活中工作上那些和自己有缘的异性，将有机会和对方确定恋爱关系。</p>
                                <p>保持对于感情的耐心，不要因为出现一些意外变故就选择放弃爱情。只有经历过磨难的爱情才可以更为甜蜜。</p>";

                        $wenan_mdth_arr[3] = "<p>您命中有:红艳桃花5朵</p>
                                <p class='p_t10'></p>
                                <img src='images/hua01.png' align='left' style='width:.65rem;margin-right:.05rem;vertical-align: top;''>
                                <p class='f_s16 co_0000f5'>红艳桃花</p>
                                <p>高雅优美追求者众</p>
                                <p>在人生的旅程中，您的恋爱或结婚对象很容易出现，多半是“近水楼台先得月”，因为常常在住家附近，学校，社团，或是工作场合见面而认识，一不小心就擦出爱的火花。若是您到现在，对象还没有出现，您身边认识的人中，长得文质彬彬，最有气质的那一位可能就是您的对象了，只要真心诚意去追求，幸福就在您身边。</p>";

                        $wenan_hyjs_arr[0] = "八字中".$yinyuancs_data['user']['sex']."命伤官透干生财，不宜早婚、最佳结婚年龄22岁、23岁、25岁、27岁。另外结婚{{allData.user.xingming.ming}}的八字总体而言感情运势一般，如若早婚会出现早婚必离的情况，所以在结婚之前多谈几次恋爱，可以有效的排泄婚后的感情不良因素，从而提高婚后感情质量。";

                        if($yinyuancs_data['user']['sex']=="男"){
                            $wenan_hyjs_arr[1] = "因强烈的责任感，在有一定经济基础后，才考虑婚姻的想法。您在28岁前后，有一次结婚运的顶峰，错过之后，在30岁前奠定事业基础，后再慢慢考虑婚姻为宜。30岁左右是您的婚姻运上升期，晚婚为宜。";
                        }else{
                            $wenan_hyjs_arr[1] = "您25岁以前，容易陷入恋情，而遇人不淑，27岁前后的结婚运会上升，看男性的眼光变得严格挑剔，因此也不容易上当受骗，对婚姻的态度比较谨慎，再出现命中注定的邂逅，看准是他，就会想结婚安定下来。";
                        }

                        if($yinyuancs_data['user']['sex']=="男"){
                            $wenan_hyjs_arr[2] = "28岁后及30岁是结婚运的上升期，您不喜欢被束缚，也不想太早步入婚姻，若在此时出现有望的对象，将经过几年恋爱的考验期，有可能顺利结婚。28岁以前，对结婚抱有敬而远之的态度。即使是不愿结婚，其中也有先试婚之人。30岁婚姻运再度上升。错过此次机会的人，就有可能一辈子单身了。";
                        }else{
                            $wenan_hyjs_arr[2] = "30岁之前会以事业为重，一旦过了30岁，结婚欲望上升，有希望成家的念头。33-35岁因周围的人结婚而受刺激产生想成家的念头。所以容易闪电结婚。35岁以后，兴趣将会转移，失去成家的想法，因此结婚时机需要把握好。";
                        }
                        if($yinyuancs_data['user']['sex']=="男"){
                            $wenan_hyjs_arr[3] = "您在25～27岁时对结婚有强烈的期盼，但是往往热恋之后，并没有结果。过了27岁之后就要经过对事业及兴趣专注的另一个时期，在30岁后会迎来旺盛的结婚运。";
                        }else{
                            $wenan_hyjs_arr[3] = "您对婚姻有很高的期望，希望婚后生活如同理想一般的完美。在27岁之后，比较容易遇到适宜的结婚对象。进入30岁后结婚运下降，反而事业运上升。到了35岁之后，变得和婚姻更无缘，对婚姻的热中也冷却下来，其中更有抱有终身不嫁的念头。";
                        }

                        $wenan_wdxg_arr[0] = "比肩为喜用，外表平凡却外虚内实，用心努力之人，善于比较选择，改良创办，意志坚定不易改变立场，与朋友交往重实质情谊。 一般而言比肩是象征意志坚定，自尊心强，分别是非，择善固执，坚守岗位，忍耐心很强，常能在逆境中完成心愿。（重点）";
                        $wenan_wdxg_arr[1] = "您个性随遇而安，能接纳别人，属于有大智慧，非小聪明的类型。您个性比较随和，但有点木讷，虽然有许多宝贵的看法，却不随便表示意见。您也不喜欢邀功，所以一般人容易忽略您的贡献，一旦您离开了原先的岗位，人们才会发觉您的重要性。因此您的心防也很强，一般人不容易进入您的内心世界。您的内心却很执着，对于坚持到底的事情不轻易放弃，有点择善固执。";
                        $wenan_wdxg_arr[2] = "您聪明有才华，学习能力强，观察敏锐，喜欢探究事物背后的道理，思路清晰，有独具一格的判断与分析能力，但是缺乏执行力与行动力。您的思路十分活跃，想象力丰富，但是缺乏持续力，容易流于空谈。您能够以不同的角色来适应周遭的环境，不论多恶劣，您也能渐渐适应，进而改变环境。您思考能力强，但执行能力弱，您对周遭生活有很多的不满与期待，也有能力改善，但就是不容易付诸行动。";
                        $wenan_wdxg_arr[3] = "您开朗活泼，热心大方，不会斤斤计较，对于公理正义非常执着。您天生具有领袖命，有表现欲望，但也有牺牲奉献的精神。您喜欢一视同仁，公私分明，不喜欢有人假公济私，或搞小团体。您也很有规律性以及耐心，极少半途而废，而且您也不能接受有人命令您要做什么，或不做什么。";



                        $wenan_poxg_arr[0] = "伤官心性。优点：领悟力强，理想高远，追求完美生活。有独裁倔强个性。自信甚强，斗志昂扬，学习能力强，易成英雄人物。伤官在命，若非多学多能，就是相貌清秀。在自由事业，精密技术、演艺事业方面，易获特殊成功，也可站在台前或从事口才之事业。缺点：领悟力与兴趣广泛，博而不精。易恃才而骄，不喜世俗礼法拘束，行为易致任性乖张。为达目的，甚或以私害公，伤人而不自知。如原局再财多，则会贪得无厌。好管闲事，易招人误会。";
                        $wenan_poxg_arr[1] = "您喜欢有魄力与义气的人，而能让您佩服的人，多半是能牺牲奉献，平等待人的人。您的付出，在当时不一定立刻会有回报，但是长久的相处，总能让对方知道你的好。";
                        $wenan_poxg_arr[2] = "您喜欢平易近人，亲切友善的人，不喜欢油嘴滑舌，虚情假意的人，而能让您佩服的人，多半是成熟稳重，诚恳踏实的人。";
                        $wenan_poxg_arr[3] = "您喜欢老实诚信的人，不喜欢自以为是的人，而能让您佩服钦慕的人，多半是有想法，才华与智慧的人，能够在心灵上让您提升的人。";

                        $wenan_hhcy_arr[0] = "正才为忌神，但夫妻宫为喜用神，表明对方自身条件好、品质好，但却不能帮助自己。另外从你的八字性格上看，婚姻生活会多多少少的受到你的性格影响导致感情淡化。对于女性而言、婚后控制好自己的性格能够提升感情运势哦！古人云：修身养性才是渡世金方！感情方面也是如此！";

                        $wenan_hhcy_arr[1] = "您并不善于理财，但是懂得金钱的可贵。您会比一般人更早开始工作，所以当别人在挥霍金钱，享受生命的时候，您在计划未来，所以未来自然能够累积更多的财富。此外，您比较早熟，不会在不必要的地方花钱，但是您对于投资未来，以及对于事业有帮助的花费不会吝啬，您也希望未来能够自己当老板，有自己的事业。因此找一个善于理财的另一半对您助益良多。";

                        $wenan_hhcy_arr[2] = "您不容易守财，也不容易储蓄，每次累积到一定的财富就会发生一些事情让您花钱。在您手头比较紧的时候，该花的钱您还是会花，不会一毛不拔；在您手头比较宽裕的时候，您花钱会很大方，不会对自己、家人或朋友小气。您今生大部份的财富会被您拿来做自己想做的事情，您会认为您使用过的金钱才是您真正拥有的财富。之后，这些财富大半会遗留给子孙。";

                        $wenan_hhcy_arr[3] = "根据命理分析，您的命局为正财格，未来的您，很会赚钱，也很会花钱。您从很年轻的时候就知道钱财的重要性，因此您会比一般人更早开始理财，所以当别人在挥霍金钱，享受生命的时候，您在计划未来，所以未来自然能够累积更多的财富。您天生比较精明，不会在不必要的地方花钱，但是您会有许多计划性的支出。您今生大部份的财富会被您储蓄起来，或是理财，或是置产，或是投资创业，或是投资自己。";

                        $wenan_xfzs_arr[0] = "其实从总体来看！感情运势早年会有所波折！但婚后感情质量会慢慢上升。除了上述的性格方面和外界因素之外、其导致你感情淡化的另外一个因素就是八字中的命运、我们说一命二运三风水。既然命运如此、那么我们可以通过环境风水来提升这方面的运势！由于风水布局需要因地制宜，故针对你的八字而言，可以佩戴一些黑色或者五行属水的饰品、来增旺你的感情运势。如果有兴趣可以关注下方我们的微信号，可以在线向我们的命理师傅提问哦！";

                        $wenan_xfzs_arr[1] = "延年在东北方，东北方是您的桃花贵人位；伏位在东方，东方是本命宅财位；天医在北方，北方是平安健康位；伏位在南方，南方是您的事业财运位，您可以摆放一些开运的吉祥物或者绿植来改善婚姻、财运情况。西南、西北、东南为煞位，注意避让。";

                        $wenan_xfzs_arr[2] = "延年在西北，西北方是您的桃花贵人位，生气在东北方，东北方是您的事业财运位；天医在西方，西方是您的平安健康位，伏位在西南方，西南是您的本命宅财位。您可以在相应的方位摆放一些开运的吉祥物或者绿植来改善婚姻、财运、健康运势情况。东方、东南方、南方、北方为煞位，注意避让。";

                        $wenan_xfzs_arr[3] = "延年在西方，西方是您的桃花贵人位；生气在西南方，西南方是您的事业财运位；天医在西北方，西北方是您的平安健康位；伏位在东北方，东北方是您的本命宅财位，您可以在相应的方位摆放一些开运的吉祥物或者绿植来改善婚姻、财运、健康运势情况。南方、东方、东北、东南方为四煞方位，注意避让。";

                        $wenan_znzs_arr[0] = "<p>1、印星现时柱，子女聪明仁慈，孝顺父母。</p>
                            <p>2、阳日阴时先生男后生女。</p>
                            <p>3、如果怀孕，预产之年如与丈夫四柱时支相冲，要预防流产。</p>
                            <p>4、遇伤官流年易生儿子。</p>
                            <p>5、食伤为忌神，但子女宫为喜用神，表明子女自身条件好、品质好，但却不能帮助自己。</p>";

                        $wenan_znzs_arr[1] = "<p>1、子女缘分指数：4颗星</p>
                            <p>2、子女宫有吉星庙旺，主子女昌盛，事业有成；命中子女星众多，一生会有两个以上子女。</p>
                            <p>3、女星自坐子女宫，小孩日后有能力，具有才干。</p>
                            <p>4、但是自己不会得到子女太多的帮助，也表示子女缘分不够深，子女工作学业的发展，需要你劳心劳力，做出更多的贡献。</p>
                            <p>5、食伤为忌神，但子女宫为喜用神，表明子女自身条件好、品质好，但却不能帮助自己。</p>";

                        $wenan_znzs_arr[2] = "<p>1、子女缘分指数：5颗星</p>
                            <p>2、命格中吉星守值拱照，子女可多且优良，出生富贵，福大命大，一生衣食无忧。。</p>
                            <p>3、后代聪慧过人，年幼时即展现过人的才智。</p>
                            <p>4、子女缘分深厚，后代多重情，感恩，生活有子女相伴，幸福安康。</p>
                            <p>5、食伤为忌神，但子女宫为喜用神，表明子女自身条件好、品质好，但却不能帮助自己。</p>";

                        $wenan_znzs_arr[3] = "<p>1、子女缘分指数：3颗星。</p>
                            <p>2、命格中遇天机，子女晚得，老来得子，视为珍宝，切忌过度溺爱，年幼时资质平平，经后天培养可一举成才。</p>
                            <p>3、子女少，多为一到二胎，中年聚少离多，晚年子女成材，孝顺父母，能得子女相伴左右，安度后半生。</p>
                            <p>4、食伤为忌神，但子女宫为喜用神，表明子女自身条件好、品质好，但却不能帮助自己。</p>";

                        //返回随机数组键名
                        $rand_key = array_rand($wenan_poqk_arr,1);
                        $yinyuancs_data['wenan_poqk_arr'] = $wenan_poqk_arr[$rand_key];
                        $yinyuancs_data['wenan_hyfm_arr'] = $wenan_hyfm_arr[$rand_key];
                        $yinyuancs_data['wenan_hyys_arr'] = $wenan_hyys_arr[$rand_key];
                        $yinyuancs_data['wenan_hyjy_arr'] = $wenan_hyjy_arr[$rand_key];
                        $yinyuancs_data['wenan_aqfx_arr'] = $wenan_aqfx_arr[$rand_key];
                        $yinyuancs_data['wenan_mdth_arr'] = $wenan_mdth_arr[$rand_key];
                        $yinyuancs_data['wenan_hyjs_arr'] = $wenan_hyjs_arr[$rand_key];
                        $yinyuancs_data['wenan_poxg_arr'] = $wenan_poxg_arr[$rand_key];
                        $yinyuancs_data['wenan_hhcy_arr'] = $wenan_hhcy_arr[$rand_key];
                        $yinyuancs_data['wenan_xfzs_arr'] = $wenan_xfzs_arr[$rand_key];
                        $yinyuancs_data['wenan_znzs_arr'] = $wenan_znzs_arr[$rand_key];

                        $row['type'] = $this->get_action($row['type']);
                        //$redis_data[$data['order_sn']] = $row;
                        //$this->save_order_redis($this->token,$redis_data);
                        $this->return_format(1,'测算成功',$yinyuancs_data);
                    }
                }else{
                    $this->return_format(10002,'订单不存在',[]);
                }
            }
        }catch (\Exception $e){
            $this->return_format(10004,$e -> getMessage());
        }

    }

    /**
     *八字算命【八字精批】测算API
     */
    public function bazijpAction(){

		header('Access-Control-Allow-Origin:*');

        $type = 1;//测算类型-八字精批
        $data = (new BaZiJpValidate()) -> go_check();
        try{
            if(!isset($data['order_sn'])){

                if(!empty($data['full_name'])) {
                    $xmgl = Xmgl::findFirst([
                        "conditions" => "fullname=:fullname:",
                        "bind" => ['fullname' => $data['full_name']]
                    ]);
                    if ($xmgl) {
                        throw new \Exception('抱歉，本站无法处理您的请求！');
                    }
                }

                //生成订单
                $money = $this -> money;
                $y_money = $this -> y_money;
                $order_sn = date('YmdGis').time().rand(100, 999);
                $des = $data['full_name'].'的八字精批';
                $data = ['full_name'=>$data['full_name'],'sex'=>$data['sex'],'year'=>$data['year'],'month'=>$data['month'],'day'=>$data['day'],'hour'=>$data['hour'],'i'=>$data['i'],'c_year'=>$data['c_year'],'c_month'=>$data['c_month'],'c_day'=>$data['c_day'],'c_hour'=>$data['c_hour'],'term1'=>$data['term1'],'term2'=>$data['term2'],'start_term'=>$data['start_term'],'end_term'=>$data['end_term'],'start_term1'=>$data['start_term1'],'end_term1'=>$data['end_term1'],'lDate'=>$data['lDate']];
                $datas = array('data'=>urlencode(json_encode($data)),'oid'=>$order_sn,'createtime'=>time(),'type'=>$type,'ip'=>\StringHelpers::get_real_ip(),'des'=>$des,'money'=>number_format($money,2),'open_id'=>$this->token);

                // 分销追踪
                $ad_code_id = $this->post_params("ad_code_id", "int", 0);
                $datas['ad_id'] =  $ad_code_id > 0 ?  $ad_code_id : 0;
                if($datas['ad_id'] > 0){
                   $ad_source = $this->post_params("ad_source", "int", 0);
                   \DistributorHelpers::insert($this->master_db, $datas['ad_id'], $order_sn, $money,  81, 2, $ad_source);
                }
                // End 分销

                //存入订单表
                (new \Yw11smorders()) -> insert_record($datas);
                $return_data=[
                    'order_sn'=>$order_sn,
                    'data'=>$data,
                    'des'=>$des,
                    'money'=>number_format($money,2),
                    'y_money'=>$y_money
                ];


                $this->return_format(1,'八字精批订单生成成功',$return_data);
            }else{
                $row = (new \Yw11smorders())->get_record_by_oid($data['order_sn']);

                if($row){
                    if($row['status']!=1){
                        $this->return_format(10001,'该订单未支付',[]);
                    }else{
                        $arr = json_decode(urldecode($row['data']),true);
                        $bazijp_data = (new BaZiZhService())->bazizh($arr);
                        $yuefen = (new BaZiZhService())->yuefen($bazijp_data['user']['sx']);
                        $bazijp_data['sx']['yf'] = $yuefen;
                        $pp = (new BaZiZhService()) -> bazipp($arr);
                        $bazijp_data['pp'] = $pp;
                        $bazijp_data['user_data'] = $arr;
                        //将当前订单数组数据存入redis
                        $row['type'] = $this->get_action($row['type']);
                        $redis_data[$data['order_sn']] = $row;
                        //组装八字精批的文案
                        if(isset($bazijp_data['data']['zonghe']['aqfx']) && !empty($bazijp_data['data']['zonghe']['aqfx'])){
                            $wenan_aqfx_yd_arr[0] = $bazijp_data['data']['zonghe']['aqfx'];
                        }else{
                            $wenan_aqfx_yd_arr[0] = $bazijp_data['user']['sex']==1?"男":"女"."性有知性的魅力，稍带忧郁的气质很受异性的欢迎。凡是追求的异性，一概来者不拒，一个星期可能和七个人约会。此外，因他具有果敢的行动力，所以也常会主动邀约他人。壬日男性很擅长“一夜风流”，从吃饭、饮酒到饭店这一个过程视以知性的背景，制造了绝妙的气氛，使他们无往不利。由于自由的恋爱观，使他们甚少有从一异性而终的心态。";
                        }
                        $wenan_aqfx_yd_arr[1] = "您的整体爱情运势尚佳，与自己兮兮相惜的对象懂得如何更进一步加深两人之间的感情，，也能够在对方的信任中更加的茁壮成长，这对彼此的感情来说是很好的发展。他能够与自己所爱的人花好月圆，得到一个圆满的结局。";
                        $wenan_aqfx_yd_arr[2] = "您的整体爱情运势顺风顺水，遇到一些问题能够逢凶化吉，对于感情生活会带来不小的帮助，已有恋情的你在这一年虽然也会和自己的另一半发生矛盾和争吵，但很快就会过去，过后感情生活会更加亲密。单身的你更有机会在感情关系上有重大突破。";
                        $wenan_aqfx_yd_arr[3] = "年逢吉星“三台”坐镇，能够在更大程度上强化您今年的运势。爱情运势方面您会遇到很多异性，其中也会有不少让你们心动的，而且能够与其相恋，但是必须注意稳定自己的意志，否则很容易会演化为烂桃花，给生活造成一定不利影响。";

                        $wenan_mlth_arr[0] = "顾名思义，红艳给人感受如同花开美好又灿烂，主众人见你心喜，本人气质出众，有特殊的魅力与好人缘，以至于本人在爱情追求上如虎添翼。红艳桃花，全名红艳桃花煞。命带红艳桃花，象征当事人外缘极佳，感情世界丰富。除了吸引异性欣赏，命带红艳桃花者，本身性情亦属浪漫多情，面对追求者示爱，很容易动情而接受对方。在你的八字格局里有红艳桃花，象征你发生一见锺情的机率很高，往往会在电石火光间遇到了那个对的人与恋人的发展关系往往是激情四射，当然这样的感情来得快也去得快。因为命带红艳桃花，象征本人异性缘佳，且生性多情。即使身旁已有交往对象，仍会吸引其他异性追求，若本身意志不坚，很容易就风流韵事不断，造成爱情运势不稳、感情容易生变。";
                        $wenan_mlth_arr[1] = "八字中官带桃花，日支坐官星，逢姻缘星“天喜”驾临，这一年里的爱情运势必然会有所提升，恋爱或者已婚中的你在这一年里感情会格外亲密，且喜事不断，让你们的生活更加甜蜜、幸福。而单身的你在一年内也有望脱单，有吉星“太阳”加“天喜”相助，不但桃花盛开，且自身魅力增加，又有贵人相助，必能脱单。";
                        $wenan_mlth_arr[2] = "桃花星“红鸾”入宫，能给您极好的爱情运势，整体运势渐入佳境，在往后一年里，异性缘极佳，个人魅力也会有所提升。单身的你在这一年里也要积极寻找自己生命中的另一半，并积极主动的示爱，这样才能够得到幸福。";
                        $wenan_mlth_arr[3] = "这一年里的您的人缘运非常旺盛，人缘运中也包括异性缘，在这一年里接触和认识异性的机会会很多，这对于单身的您或许是好事，但对于已婚或者恋爱中的您而言可能会因此而出现节外生枝，所以一定要注意把握好分寸，否则可能会招来一些不必要的误会和麻烦。";





                        //返回随机数组键名
                        $rand_key = array_rand($wenan_aqfx_yd_arr,1);
                        $bazijp_data['wenan_aqfx_yd_arr'] = $wenan_aqfx_yd_arr[$rand_key];
                        $bazijp_data['wenan_mlth_arr'] = $wenan_mlth_arr[$rand_key];
                        //$this->save_order_redis($this->token,$redis_data);
                        $this->return_format(1,'测算成功',$bazijp_data);
                    }
                }else{
                    $this->return_format(10002,'订单不存在',[]);
                }
            }
        }catch (\Exception $e){
            $this->return_format(10004,$e -> getMessage());
        }
    }

    /**
     * 【桃花运】测算API
     */
    public function bzyyAction(){

		header('Access-Control-Allow-Origin:*');

        $type = 6;//测算类型-桃花运
        $data = (new BaZiYyValidate()) -> go_check();
        try{
            if(!isset($data['order_sn'])){

                if(!empty($data['full_name'])) {
                    $xmgl = Xmgl::findFirst([
                        "conditions" => "fullname=:fullname:",
                        "bind" => ['fullname' => $data['full_name']]
                    ]);
                    if ($xmgl) {
                        throw new \Exception('抱歉，本站无法处理您的请求！');
                    }
                }

                //生成订单
                $money = $this->money;
                $y_money = $this -> y_money;
                $order_sn = date('YmdGis').time().rand(100, 999);
                $des = $data['full_name'].'的桃花运';
                $data = ['full_name'=>$data['full_name'],'sex'=>$data['sex'],'year'=>$data['year'],'month'=>$data['month'],'day'=>$data['day'],'hour'=>$data['hour'],'i'=>$data['i'],'c_year'=>$data['c_year'],'c_month'=>$data['c_month'],'c_day'=>$data['c_day'],'c_hour'=>$data['c_hour'],'term1'=>$data['term1'],'term2'=>$data['term2'],'start_term'=>$data['start_term'],'end_term'=>$data['end_term'],'start_term1'=>$data['start_term1'],'end_term1'=>$data['end_term1'],'lDate'=>$data['lDate']];
                $datas = array('data'=>urlencode(json_encode($data)),'oid'=>$order_sn,'createtime'=>time(),'type'=>$type,'ip'=>\StringHelpers::get_real_ip(),'des'=>$des,'money'=>number_format($money,2),'open_id'=>$this->token);

                // 分销追踪
                $ad_code_id = $this->post_params("ad_code_id", "int", 0);
                $datas['ad_id'] =  $ad_code_id > 0 ?  $ad_code_id : 0;
                if($datas['ad_id'] > 0){
                    $ad_source = $this->post_params("ad_source", "int", 0);
                    \DistributorHelpers::insert($this->master_db, $datas['ad_id'], $order_sn, $money,  85, 2, $ad_source);
                }
                // End 分销

                //存入订单表
                (new \Yw11smorders()) -> insert_record($datas);
                $return_data=[
                    'order_sn'=>$order_sn,
                    'data'=>$data,
                    'des'=>$des,
                    'money'=>number_format($money,2),
                    'y_money'=>$y_money
                ];
                //将当前未支付订单数组数据存入redis
//                $datas['status'] = 0;//订单未支付
//                $datas['data'] = $data;
//                $redis_data[$order_sn] = $datas;
//                $this->save_order_redis($this->token,$redis_data);

                $this->return_format(1,'八字姻缘订单生成成功',$return_data);
            }else{
                $row = (new \Yw11smorders())->get_record_by_oid($data['order_sn']);
                if($row){
                    if($row['status']!=1){
                        $this->return_format(10001,'该订单未支付',[]);
                    }else{
                        $arr = json_decode(urldecode($row['data']),true);
                        $bzyy_data = (new BaZiYyService())->bzyy($arr);
                        $yuefen = (new BaZiYyService())->yuefen($bzyy_data['user']['sx']);
                        $bzyy_data['sx']['yf'] = $yuefen;
                        $pp = (new BaZiYyService()) -> bazipp($arr);
                        $bzyy_data['pp'] = $pp;
                        $bzyy_data['user_data'] = $arr;
                        //将当前订单数组数据存入redis
                        $row['type'] = $this->get_action($row['type']);
                        $redis_data[$data['order_sn']] = $row;
                        //组装桃花运的文案
                        $wenan_bzyy_arr[0] = "";


                        //$this->save_order_redis($this->token,$redis_data);
                        $this->return_format(1,'测算成功',$bzyy_data);
                    }
                }else{
                    $this->return_format(10002,'订单不存在',[]);
                }
            }
        }catch (\Exception $e){
            $this->return_format(10004,$e -> getMessage());
        }
    }

    /**
     * 姓名配对测算API
     */
    public function xmpdAction(){

        $type = 4;//测算类型-姓名配对
        $data = (new XmpdValidate()) -> go_check();
        try{
            if(!isset($data['order_sn'])){

                if(!empty($data['malename'])) {
                    $xmgl = Xmgl::findFirst([
                        "conditions" => "fullname=:fullname:",
                        "bind" => ['fullname' => $data['malename']]
                    ]);
                    if ($xmgl) {
                        throw new \Exception('抱歉，本站无法处理您的请求！');
                    }
                }

                if(!empty($data['femalename'])) {
                    $xmgl = Xmgl::findFirst([
                        "conditions" => "fullname=:fullname:",
                        "bind" => ['fullname' => $data['femalename']]
                    ]);
                    if ($xmgl) {
                        throw new \Exception('抱歉，本站无法处理您的请求！');
                    }
                }

                //生成订单
                $money = $this->money;
                $y_money = $this -> y_money;
                $order_sn = date('YmdGis').time().rand(100, 999);
                $des = $data['malename'].'与'.$data['femalename'].'的姓名配对';
                $data = ['malename'=>$data['malename'],'femalename'=>$data['femalename']];
                $datas = array('data'=>urlencode(json_encode($data)),'oid'=>$order_sn,'createtime'=>time(),'type'=>$type,'ip'=>\StringHelpers::get_real_ip(),'des'=>$des,'money'=>number_format($money,2),'open_id'=>$this->token);

                // 分销追踪
                $ad_code_id = $this->post_params("ad_code_id", "int", 0);
                $datas['ad_id'] =  $ad_code_id > 0 ?  $ad_code_id : 0;
                if($datas['ad_id'] > 0){
                    $ad_source = $this->post_params("ad_source", "int", 0);
                    \DistributorHelpers::insert($this->master_db, $datas['ad_id'], $order_sn, $money,  80, 2, $ad_source);
                }
                // End 分销

                //存入订单表
                (new \Yw11smorders()) -> insert_record($datas);
                $return_data=[
                    'order_sn'=>$order_sn,
                    'data'=>$data,
                    'des'=>$des,
                    'money'=>number_format($money,2),
                    'y_money'=>$y_money
                ];
                //将当前未支付订单数组数据存入redis
//                $datas['status'] = 0;//订单未支付
//                $datas['data'] = $data;
//                $redis_data[$order_sn] = $datas;
//                $this->save_order_redis($this->token,$redis_data);

                $this->return_format(1,'姓名配对订单生成成功',$return_data);
            }else{
                $row = (new \Yw11smorders())->get_record_by_oid($data['order_sn']);
                if($row){
                    if($row['status']!=1){
                        $this->return_format(10001,'该订单未支付',[]);
                    }else{

                        $arr = json_decode(urldecode($row['data']),true);
                        //处理姓氏

                        $male_xing = $this->t4($arr['malename']);
                        $male_ming = mb_substr($arr['malename'],mb_strlen($male_xing));
                        $fale_xing = $this->t4($arr['femalename']);
                        $fale_ming = mb_substr($arr['femalename'],mb_strlen($fale_xing));

                        $arr['male_xing'] = $male_xing;
                        $arr['male_name'] = $male_ming;
                        $arr['female_xing'] = $fale_xing;
                        $arr['female_name'] = $fale_ming;

                        $xmpd_data = (new XmpdService())->xmfx($arr);

                        $xmpd_data['user_data'] = $arr;

                        $wenan_sfaqsm_boy_arr[0] =$xmpd_data['tdrh_ge_arr']['yuanshen']['msg']."「一旦认定对方，就会全心全意付出」这是你最迷人的地方。虽然不是最浪漫的情人，但是，绝对是最能带给伴侣安全感的好男人！";
                        $wenan_sfaqsm_boy_arr[1] =$xmpd_data['tdrh_ge_arr']['yuanshen']['msg']."在恋爱中，你是挺温和的一个人的。很少会去跟另一半争执，只要有矛盾，总是主动道歉的哪一方。这已经形成了一种恋爱习惯，所以跟你谈恋爱是挺幸福的一件事的，因为你的包容心，让你的恋人能随意的耍小性子。";
                        $wenan_sfaqsm_boy_arr[2] =$xmpd_data['tdrh_ge_arr']['yuanshen']['msg']."会把自己想要去做什么事情，提前报备给另一半，让对方安心。平常是没有安全感的一个人，希望能时刻了解对方的动向，将心比心，因此也会把自己的情况如实相告。在面对恋人的时候，说话总是特别的温柔。非常重感情，也有自己的底线，一旦开始一段全新的感情，就绝不会再去跟前任纠缠不休。";
                        $wenan_sfaqsm_boy_arr[3] =$xmpd_data['tdrh_ge_arr']['yuanshen']['msg']."在别人面前，是特别高冷的一个人，不喜欢跟人走得太近，可能会显得比较孤僻。但是在恋爱中，却异常热情，想要把最好的给对方。直都是比较爽快的一个人，他们很有魄力，恋人想要什么，说买就买，绝不心痛。遇到真爱之后，比较有危机感。会把事情想得很长远，会提前考虑到两个人可能经过的每一个阶段，然后这样才会心安，知道如何应对。";

                        $wenan_sfaqsm_girl_arr[0] =$xmpd_data['tdrh2_ge_arr']['yuanshen']['msg']."你从不吝於向另一半表达心目中浓浓爱意。即使处在暧昧不明的暗恋阶段，你的心仪对象，也绝对逃不过你那热情放送的强力电波。面对爱情，你的态度勇敢而直接，走出失恋/苦恋阴霾的速度，往往快得吓人。";
                        $wenan_sfaqsm_girl_arr[1] =$xmpd_data['tdrh2_ge_arr']['yuanshen']['msg']."非常注重仪式感，喜欢跟另一半一起庆祝各种各样的节日，不管是情人节也好，劳动节也好，都会拉着自己的另一半好好的用自己的方式度过。非常浪漫的一个人，遇到真心喜爱的人，会喜欢撒娇。在喜欢的人面前，完全不需要伪装，会大方的表达自己的爱意。";
                        $wenan_sfaqsm_girl_arr[2] =$xmpd_data['tdrh2_ge_arr']['yuanshen']['msg']."很喜欢腻歪在爱人身边，对恋人的依赖感比较重，因为这样才会感觉到很有安全感。而且在恋人身边感觉温暖，即便什么事都不做，也会觉得很满足，同时也是很长情的一个人，爱上一个人的时候，就希望天荒地老。";
                        $wenan_sfaqsm_girl_arr[3] =$xmpd_data['tdrh2_ge_arr']['yuanshen']['msg']."喜欢跟爱人沟通交流，经常主动打电话给对方，要坚持每天联系，害怕感情变淡。开始一段感情，就会非常的投入，全心全意的为对方考虑，关于对方事无巨细都很想要知道，从不吝啬表达自己的爱意，面对爱情的态度异常真挚、勇往直前。";

                        if(isset($xmpd_data['gua']['jianyi']) && !empty($xmpd_data['gua']['jianyi'])){
                            $wenan_aqjy_arr[0] = $xmpd_data['gua']['jianyi'];
                        }else{
                            $wenan_aqjy_arr[0] = "一个温吞吞，一个急匆匆，如果两人真的走在一起，不妨像网球双打一样，一个补、一个攻，也许发展更为稳健，当然，大前提是是已经能完全理解和接受对方的特性。男生要更主动、加大追求力度。女生则要学习男生深思熟虑的处事态度，顺着这个趋势，相互补足，彼此迁就，共同进步，你们在生活上就不容易因为太过迥异的性格绊住脚步了。";
                        }
                        $wenan_aqjy_arr[1] = "感情中都需要体谅，但是谁也不是圣人不可能没有错误，如果相爱就要学会理解和包容，内心要会宽容，要有一颗宽大的心。感情中千万别互相猜忌，有些事情越思考就越容易钻牛角尖。感情中最重要的就是建立信任感。";
                        $wenan_aqjy_arr[2] = "爱情需要适当的放松，即便再相爱的两个人，也需要彼此的私人空间，管的越宽，矛盾爆发的几率也就越大，女方平常少一点多愁善感，不要因为争吵中对方随便脱口而出的一句话，然后难过伤心。男方需要多照顾一下恋人的心态，她可能比较情绪化，但是相反，也是相当好哄的类型，两人好好相处，开花结果不是什么难事。";
                        $wenan_aqjy_arr[3] = "重视爱情道路上的和谐关系，尤其是当情感经受考验的时候。幸福是两个人共同要努力的争取来的，不是一个人的付出和另一个人的享受。由于两人比较重感情，也比较敏感，面对爱情的煎熬和考验，时常感觉到迷惑和冲动。因此，在面对困境时，两人的彼此扶持、彼此理解就显得尤为重要。";

                        //返回随机数组键名
                        $rand_key = array_rand($wenan_sfaqsm_boy_arr,1);
                        $xmpd_data['wenan_sfaqsm_boy_arr'] = $wenan_sfaqsm_boy_arr[$rand_key];
                        $xmpd_data['wenan_sfaqsm_girl_arr'] = $wenan_sfaqsm_girl_arr[$rand_key];
                        $xmpd_data['wenan_aqjy_arr'] = $wenan_aqjy_arr[$rand_key];
                        //将当前订单数组数据存入redis
                        $row['type'] = $this->get_action($row['type']);
                        $redis_data[$data['order_sn']] = $row;
                        //$this->save_order_redis($this->token,$redis_data);
                        $this->return_format(1,'测算成功',$xmpd_data);
                    }
                }else{
                    $this->return_format(10002,'订单不存在',[]);
                }
            }
        }catch (\Exception $e){
            $this->return_format(10004,$e -> getMessage());
        }
    }

    /**
     * 财运详匹测算API
     */
    public function cyxpAction(){

		header('Access-Control-Allow-Origin:*');

        $type = 8;//测算类型-财运分析
        $data = (new CyxpValidate()) -> go_check();

        try{
            if(!isset($data['order_sn'])){

                if(!empty($data['full_name'])) {
                    $xmgl = Xmgl::findFirst([
                        "conditions" => "fullname=:fullname:",
                        "bind" => ['fullname' => $data['full_name']]
                    ]);
                    if ($xmgl) {
                        throw new \Exception('抱歉，本站无法处理您的请求！');
                    }
                }

                //生成订单
                $money = $this->money;
                $y_money = $this -> y_money;
                $order_sn = date('YmdGis').time().rand(100, 999);
                $des = $data['full_name'].'的财运分析';
                $data = ['full_name'=>$data['full_name'],'sex'=>$data['sex'],'year'=>$data['year'],'month'=>$data['month'],'day'=>$data['day'],'hour'=>$data['hour'],'i'=>$data['i'],'c_year'=>$data['c_year'],'c_month'=>$data['c_month'],'c_day'=>$data['c_day'],'c_hour'=>$data['c_hour'],'term1'=>$data['term1'],'term2'=>$data['term2'],'start_term'=>$data['start_term'],'end_term'=>$data['end_term'],'start_term1'=>$data['start_term1'],'end_term1'=>$data['end_term1'],'lDate'=>$data['lDate']];
                $datas = array('data'=>urlencode(json_encode($data)),'oid'=>$order_sn,'createtime'=>time(),'type'=>$type,'ip'=>\StringHelpers::get_real_ip(),'des'=>$des,'money'=>number_format($money,2),'open_id'=>$this->token);

                // 分销追踪
                $ad_code_id = $this->post_params("ad_code_id", "int", 0);
                $datas['ad_id'] =  $ad_code_id > 0 ?  $ad_code_id : 0;
                if($datas['ad_id'] > 0){
                    $ad_source = $this->post_params("ad_source", "int", 0);
                    \DistributorHelpers::insert($this->master_db, $datas['ad_id'], $order_sn, $money,  84, 2, $ad_source);
                }
                // End 分销

                //存入订单表
                (new \Yw11smorders()) -> insert_record($datas);
                $return_data=[
                    'order_sn'=>$order_sn,
                    'data'=>$data,
                    'des'=>$des,
                    'money'=>number_format($money,2),
                    'y_money'=>$y_money
                ];
                //将当前未支付订单数组数据存入redis
//                $datas['status'] = 0;//订单未支付
//                $datas['data'] = $data;
//                $redis_data[$order_sn] = $datas;
//                $this->save_order_redis($this->token,$redis_data);

                $this->return_format(1,'财运分析订单生成成功',$return_data);
            }else{

                $row = (new \Yw11smorders())->get_record_by_oid($data['order_sn']);
                if($row){
                    if($row['status']!=1){
                        $this->return_format(10001,'该订单未支付',[]);
                    }else{
                        $arr = json_decode(urldecode($row['data']),true);
                        $cyxp_data = (new CyxpService())->cyxp($arr);
                        $yuefen = (new CyxpService())->yuefen($cyxp_data['user']['sx']);
                        $cyxp_data['sx']['yf'] = $yuefen;
                        $pp = (new CyxpService()) -> bazipp($arr);
                        $cyxp_data['pp'] = $pp;
                        $cyxp_data['user_data'] = $arr;
                        //将当前订单数组数据存入redis
                        $row['type'] = $this->get_action($row['type']);
                        $redis_data[$data['order_sn']] = $row;
                        //$this->save_order_redis($this->token,$redis_data);
                        //组合财运详匹文案
                        $wenan_cyxp_yscy_arr[0] = "<p class='gdw'>一生财运主要是看你的赚钱方式能力，对钱财运用情况及富有程度的方面，而属于你的一生财运状况有以下几方面是</p>
                            <p>根据你的八字情况，你的财星多福气；如遇到好的格局助力，则预示赚钱轻松，能不费太多力气就能取得财富；你财运比较的稳定，而且非常重视自己的享受，对钱财看得比较轻，会花大量的钱财在个人享乐上，因此可能年轻时存不下钱，需要到了中年后才能慢慢积累财富；适合投资服务性质的行业，从事玩乐享受性质服务行业的工作也能从中获利。</p>
                            <p>你的财星旺，如遇好的格局入驻，赚钱将更加顺遂；你一生的整体财运还是不错，投资理财有头脑，做生意有谋略，能获得不俗收益；但若是有忌星干扰，资金周转上会出现问题，金钱消耗大，需要留心本人的经济状况，谨慎处理财务问题；充分利用个人潜质，主动拓展财路，才能财源广进，以财生财。</p>
                            <p>综上所诉，你的财运不俗，而且有财星助力，在得财方面比较顺遂，而且表现为多福气，不会费太多力气便能获得收益，宜往外地发展，赚钱的机会会更多，年轻奋斗努力，晚年积蓄不俗。</p>
                            <div class='ex-com'>
                                <div class='little-tit'>
                                  <span>对财运的积极影响</span>
                                </div>
                                <p class='gdw'>除了上面的财运状况特点，你的八字中还存在着对财运比较重要的积极影响</p>
                                <p>将增加进财，一生财运会增加增厚，赚钱机会更多，能积累不俗财富。</p>
                            </div>";
                        $wenan_cyxp_yscy_arr[1] = "<p class='gdw'>您擅长于活用资金，钱上滚钱。由于这种类型的人能在脑中迅速盘算钱的去路，确知多少年后能有多大的财产，所以能更正确地培育金钱。</p>
                            <p>您非常有数字概念，头脑转的快，点子又多，单单运用利息，恐怕无法获得满足。因此这型人常在流动快速的股票市场上决胜负。不过，点子不一定都能奏效，所以若不注意，将会过度相信自己的脑袋而招致失败。一心想站在时代的前端，而大量投资开创事业，终致基础崩溃，最后落得一无所有，但是一生只要不奢侈，大都衣食无虑。</p>
                            <div class='ex-com'>
                                <div class='little-tit'>
                                  <span>对财运的积极影响</span>
                                </div>
                                <p class='gdw'>除了上面的财运状况特点，你的八字中还存在着对财运比较重要的积极影响</p>
                                <p>将增加进财，一生财运会增加增厚，赚钱机会更多，能积累不俗财富。</p>
                            </div>";
                        $wenan_cyxp_yscy_arr[2] = "<p class='gdw'>您的存钱意识比较强，这种类型的人既不想花大钱，也不想用小钱，很擅长节衣缩食过生活。一旦有人向己借钱，会很巧妙地拒绝，贯彻实行金钱第一的信念。</p>
                            <p>对金钱的感觉非常出类拔萃，很长于运用资产，其能力不输银行的职员。很喜爱购买有奖证券等，情愿存钱也不把钱花在无谓的游玩上。由于扎实的储蓄，赚取滚雪球式的利息，将可过个安稳的老年生活。</p>
                            <div class='ex-com'>
                                <div class='little-tit'>
                                  <span>对财运的积极影响</span>
                                </div>
                                <p class='gdw'>除了上面的财运状况特点，你的八字中还存在着对财运比较重要的积极影响</p>
                                <p>将增加进财，一生财运会增加增厚，赚钱机会更多，能积累不俗财富。</p>
                            </div>";
                        $wenan_cyxp_yscy_arr[3] = "<p class='gdw'>您在财产上大都有相当的储蓄，因此颇受财运之惠，一生有稳定的经济来源，有长期安定的利息，不需四处奔忙操劳，衣食无忧，自然会有十分丰裕的增值。出身富裕但是不善理财，
也很少去考虑如何赚更多的钱，人们常说“富不过三代”，还是不要坐享其成较好。</p>
                            <div class='ex-com'>
                                <div class='little-tit'>
                                  <span>对财运的积极影响</span>
                                </div>
                                <p class='gdw'>除了上面的财运状况特点，你的八字中还存在着对财运比较重要的积极影响</p>
                                <p>将增加进财，一生财运会增加增厚，赚钱机会更多，能积累不俗财富。</p>
                            </div>";


                        $wenan_cyxp_zcpc_arr[0] = "<p class='gdw'>很多朋友都想知道自身财运如何，有没有偏财运。首先要理清一点定义，所谓的偏财，就是所有数额大小不定的收入；而正财则是所有数额大小规定的收入。</p>
                            <div>
                                <div class='little-tit'>
                                  <span>你的正财指数：92</span>
                                </div>
                                <p>你一生正财运的极好，可谓是财产丰足，财源稳定，一生积蓄不俗，而且会主动求财，求财有方，对钱财的敏感度高，能拓展财路，积累更多的财富。</p>
                            </div>
                            <div>
                                <div class='little-tit'>
                                    <span>你的偏财指数：55</span>
                                </div>
                                <p>你一生的偏财运一般，可以通过投机获得一些意外之财，有一点不劳而获的财运，但也不能沉迷投机取巧，还是要回归脚踏实地，才能积累财富。</p>
                            </div>
                            <p class='gdw ex-com-body'>正财运和偏财运的好与坏并不会注定人的富有情度，只代表你赚钱是否容易，还有适合那个类型的赚钱方式，看一生的富有情度请关注上面的一生财运分析，还有下面的破财分析。</p>";

                        $wenan_cyxp_zcpc_arr[1] = "<p class='gdw'>财为养命之源，正财通过能力所赚取的稳定财富，为生产所得；偏财指意外之财，如浮动资产、彩票、奖金、股票等外来之财。</p>
                            <div>
                                <div class='little-tit'>
                                  <span>你的正财指数：90</span>
                                </div>
                                <p>你一生正财运的极好，可谓是财产丰足，财源稳定，一生积蓄不俗，而且会主动求财，求财有方，对钱财的敏感度高，能拓展财路，积累更多的财富。</p>
                            </div>
                            <div>
                                <div class='little-tit'>
                                    <span>你的偏财指数：55</span>
                                </div>
                                <p>你一生的偏财运一般，可以通过投机获得一些意外之财，有一点不劳而获的财运，但也不能沉迷投机取巧，还是要回归脚踏实地，才能积累财富。</p>
                            </div>
                            <p class='gdw ex-com-body'>您的整体财运相当畅旺，正财收入丰足无忧，而且还会有不少意外收入，财源广进！若要投资创业或置业，今年的春季及冬季正是大好时机！但请紧记各项投资均需量力而为。横财较为反复，所以临到甜头便要及时收手，以免最终得不偿失。秋季财星破损，理财必须特别小心谨慎，以免被人暗中侵吞钱财，或堕入金钱陷阱，人财两失。财运畅旺的月份，是农历正月、三月、六月、十月及十二月。今年财运较低迷的月份，是农历二月、七月、八月及十一月；四月慎防受骗破财，七月慎防被人侵吞钱财，十一月及十二月慎防盗劫之灾。</p>";
                        $wenan_cyxp_zcpc_arr[2] = "<p class='gdw'>财为养命之源，正财通过能力所赚取的稳定财富，为生产所得；偏财指意外之财，如浮动资产、彩票、奖金、股票等外来之财。</p>
                            <div>
                                <div class='little-tit'>
                                  <span>你的正财指数：89</span>
                                </div>
                                <p>你一生正财运的极好，可谓是财产丰足，财源稳定，一生积蓄不俗，而且会主动求财，求财有方，对钱财的敏感度高，能拓展财路，积累更多的财富。</p>
                            </div>
                            <div>
                                <div class='little-tit'>
                                    <span>你的偏财指数：50</span>
                                </div>
                                <p>你一生的偏财运一般，可以通过投机获得一些意外之财，有一点不劳而获的财运，但也不能沉迷投机取巧，还是要回归脚踏实地，才能积累财富。</p>
                            </div>
                            <p class='gdw ex-com-body'>您有很好的洞察力，这型人多勤勉努力，不靠洞察力或先见力，也能够聚集努力的结晶，拥有钱财或不动产。赚得快花得快是人之常情，但您属于钱财一旦到手，就会慎重、踏实的处理的类型。如得到偏财与横财，会选择把它存起来当成结婚资金，决不会把它用在吃喝上。想来深知“聚沙成塔”的个中滋味，知道钱的好处多多。除了正式的工作外，多半也尝试各种打工增加副收入。</p>";

                        $wenan_cyxp_zcpc_arr[2] = "<p class='gdw'>财为养命之源，正财通过能力所赚取的稳定财富，为生产所得；偏财指意外之财，如浮动资产、彩票、奖金、股票等外来之财。</p>
                            <div>
                                <div class='little-tit'>
                                  <span>你的正财指数：95</span>
                                </div>
                                <p>你一生正财运的极好，可谓是财产丰足，财源稳定，一生积蓄不俗，而且会主动求财，求财有方，对钱财的敏感度高，能拓展财路，积累更多的财富。</p>
                            </div>
                            <div>
                                <div class='little-tit'>
                                    <span>你的偏财指数：72</span>
                                </div>
                                <p>你一生的偏财运一般，可以通过投机获得一些意外之财，有一点不劳而获的财运，但也不能沉迷投机取巧，还是要回归脚踏实地，才能积累财富。</p>
                            </div>
                            <p class='gdw ex-com-body'>您从很年轻的时候就知道钱财的重要性，因此会比一般人更早开始理财，所以当别人在挥霍金钱，享受生命的时候，您在计划未来，所以未来自然能够累积更多的财富。此外，您天生比较精明，不会在不必要的地方花钱，但是会有许多计划性的支出，也希望未来能够自己当老板，有自己的事业。如果以一生的时间来衡量，今生大部份的财富会被张辰储蓄起来，或是理财，或是置产，或是投资创业，或是投资自己。</p>";
                        $wenan_cyxp_zcpc_arr[2] = "<p class='gdw'>财为养命之源，正财通过能力所赚取的稳定财富，为生产所得；偏财指意外之财，如浮动资产、彩票、奖金、股票等外来之财。</p>
                            <div>
                                <div class='little-tit'>
                                  <span>你的正财指数：85</span>
                                </div>
                                <p>你一生正财运的极好，可谓是财产丰足，财源稳定，一生积蓄不俗，而且会主动求财，求财有方，对钱财的敏感度高，能拓展财路，积累更多的财富。</p>
                            </div>
                            <div>
                                <div class='little-tit'>
                                    <span>你的偏财指数：46</span>
                                </div>
                                <p>你一生的偏财运一般，可以通过投机获得一些意外之财，有一点不劳而获的财运，但也不能沉迷投机取巧，还是要回归脚踏实地，才能积累财富。</p>
                            </div>
                            <p class='gdw ex-com-body'>您不爱死存钱，性格耿直，重视义气，就算倾囊付出，也要帮助他人，不为钱拘束。假设自己手头不便，也会向别处借钱以救人急。因此，如果自己不留意，财富难以积攒。您有一颗超越金钱的心，由于不善计较得失，反而会因金钱之事伤害周围的人。他人认为十分庞大的金额，在您眼中根本不当回事，就算向人借来暂用，也会因忘记归还而造成他人的困扰。
由于天性淡泊金钱，所以尽管执着，但在金钱上却看的比较开。</p>";
                        //返回随机数组键名
                        $rand_key = array_rand($wenan_cyxp_yscy_arr,1);
                        $cyxp_data['wenan_cyxp_yscy_arr'] = $wenan_cyxp_yscy_arr[$rand_key];
                        $cyxp_data['wenan_cyxp_zcpc_arr'] = $wenan_cyxp_zcpc_arr[$rand_key];
                        $this->return_format(1,'测算成功',$cyxp_data);
                    }
                }else{
                    $this->return_format(10002,'订单不存在',[]);
                }
            }
        }catch (\Exception $e){
            $this->return_format(10004,$e -> getMessage());
        }
    }

    /**
     * 十年大运测算API
     */
    public function sndyAction(){

		header('Access-Control-Allow-Origin:*');

        $type = 9;//测算类型-十年大运分析
        $data = (new SndyValidate()) -> go_check();
        try{
            if(!isset($data['order_sn'])){

                if(!empty($data['full_name'])) {
                    $xmgl = Xmgl::findFirst([
                        "conditions" => "fullname=:fullname:",
                        "bind" => ['fullname' => $data['full_name']]
                    ]);
                    if ($xmgl) {
                        throw new \Exception('抱歉，本站无法处理您的请求！');
                    }
                }

                //生成订单
                $money = $this->money;
                $y_money = $this -> y_money;
                $order_sn = date('YmdGis').time().rand(100, 999);
                $des = $data['full_name'].'的十年大运分析';
                $data = ['full_name'=>$data['full_name'],'sex'=>$data['sex'],'year'=>$data['year'],'month'=>$data['month'],'day'=>$data['day'],'hour'=>$data['hour'],'i'=>$data['i'],'c_year'=>$data['c_year'],'c_month'=>$data['c_month'],'c_day'=>$data['c_day'],'c_hour'=>$data['c_hour'],'term1'=>$data['term1'],'term2'=>$data['term2'],'start_term'=>$data['start_term'],'end_term'=>$data['end_term'],'start_term1'=>$data['start_term1'],'end_term1'=>$data['end_term1'],'lDate'=>$data['lDate']];
                $datas = array('data'=>urlencode(json_encode($data)),'oid'=>$order_sn,'createtime'=>time(),'type'=>$type,'ip'=>\StringHelpers::get_real_ip(),'des'=>$des,'money'=>number_format($money,2),'open_id'=>$this->token);

                // 分销追踪
                $ad_code_id = $this->post_params("ad_code_id", "int", 0);
                $datas['ad_id'] =  $ad_code_id > 0 ?  $ad_code_id : 0;
                if($datas['ad_id'] > 0){
                    $ad_source = $this->post_params("ad_source", "int", 0);
                    \DistributorHelpers::insert($this->master_db, $datas['ad_id'], $order_sn, $money,  86, 2, $ad_source);
                }
                // End 分销

                //存入订单表
                (new \Yw11smorders()) -> insert_record($datas);
                $return_data=[
                    'order_sn'=>$order_sn,
                    'data'=>$data,
                    'des'=>$des,
                    'money'=>number_format($money,2),
                    'y_money'=>$y_money
                ];
                //将当前未支付订单数组数据存入redis
//                $datas['status'] = 0;//订单未支付
//                $datas['data'] = $data;
//                $redis_data[$order_sn] = $datas;
//                $this->save_order_redis($this->token,$redis_data);

                $this->return_format(1,'十年大运分析订单生成成功',$return_data);
            }else{
                $row = (new \Yw11smorders())->get_record_by_oid($data['order_sn']);
                if($row){
                    if($row['status']!=1){
                        $this->return_format(10001,'该订单未支付',[]);
                    }else{
                        $arr = json_decode(urldecode($row['data']),true);
                        $cyxp_data = (new SndyService())->sndy($arr);
                        $yuefen = (new SndyService())->yuefen($cyxp_data['user']['sx']);
                        $cyxp_data['sx']['yf'] = $yuefen;
                        $pp = (new SndyService()) -> bazipp($arr);
                        $cyxp_data['pp'] = $pp;
                        $cyxp_data['user_data'] = $arr;
                        //将当前订单数组数据存入redis
                        $row['type'] = $this->get_action($row['type']);
                        //组合十年大运文案
                        $wenan_sndy_ndfx_arr[0] = "<div class='sub-tit'>当前大运：己亥运</div>
                            <div class='red2'>综合评价：吉</div>
                            <p class='poem'>己运原是正官会，水多遇土反为贵</p>
                            <p class='poem'>财旺生官多祥瑞，身弱遇此有刑亏</p>
                            <p class='poem'>亥运禄堂倒不妨，求谋顺遂大吉昌</p>
                            <p class='poem'>买臣五十方豪富，太公八十遇文王</p>
                            <p class='poem'></p>
                            <p>结合你自身八字信息，目前所走大运对你来说是很不错的，比较适合实现自身的理想抱负，如果你对人生有想法、计划都可以在这个大运多加努力去实现。在这个大运里，你为人忠心、顺从，有理性，诚实，有责任感，头脑好，工作事业稳定，有光明正大的心态，能在事业工作方面取得好成绩，在职位或官位上较易高升，考试较易上榜，官讼较易胜诉，易得长官提拔，自己创业发展空间大，收益丰厚。另一方面，这个大运对于发展人脉关系有利，人人都愿意和你保持良好关系。而且这个大运子女运非常好，单身男性容易找到伴侣，而已婚男士能得到宝宝，和子女相处融合。</p>
                            <div class='sub-tit'>下一个大运：戊戌运（2020年~2029年）</div>
                            <div class='red2'>综合评价：吉</div>
                            <p class='poem'>戊运推来是七煞，是非口舌不可亏</p>
                            <p class='poem'>纵然五载无进退，事多混杂乱如麻</p>
                            <p class='poem'>戌运正财偏官地，财喜两旺不须疑</p>
                            <p class='poem'>时来风送腾王阁，黄鹤楼中吹玉笛</p>
                            <p class='poem'></p>
                            <p>结合你自身八字信息，目前所走大运对你来说是很不错的，比较适合实现自身的理想抱负，如果你对人生有想法、计划都可以在这个大运多加努力去实现。在这个大运中，你会变得很有冲劲，有责任感，有领导风范，万丈雄心，充满毅力与勇气，导致你在事业、名气、权利等方面都会很有大的突破，但经过奋斗与竞争才能达成目标，比方说工作得到上司重用，升职加薪，创业者公司也慢慢步入正轨，当官者稳步升迁，求名者名利双休。另一方面，这个大运对于发展人脉关系有利，人人都愿意和你保持良好关系。这个大运子女运非常好，单身男性容易找到伴侣，而已婚男士能得到宝宝，和子女相处融合。</p>";
                        $wenan_sndy_ndfx_arr[1] = "<div class='sub-tit'>当前大运：丙午运</div>
                            <div class='red2'>综合评价：吉</div>
                            <p class='poem'>丙运偏财喜洋洋，百事亨通万事昌。</p>
                            <p class='poem'>午运行来好美景，财帛广招喜盈庭。</p>
                            <p class='poem'>不用劳禄多吉利，好似顺水任舟行。</p>
                            <p class='poem'></p>
                            <p>根据你的自身八字信息，你的流年行运非常不错，生活顺风顺水，在走到此大运时，带有主动性独立自主，心胸大且不重视慾望，重朋友的特性，刚强稳健意志坚强，精力充沛，朋友兄弟易得同业之运佳，事事水到渠成，有扩充工作事业之野心念头。有工作事业心，生活向上乐观积极主动，不安心于现状，有魄力开创事业接受挑战，有征服欲和占有欲。朋友交往多，生活中昔日多年不曾来往的朋友也会出现。能得到朋友或兄弟帮助有意外收获，事业发展迅速；财运昌盛，能实现心中理想。</p>
                            <div class='sub-tit'>下一个大运：丁未运（2020年~2029年）</div>
                            <div class='red2'>综合评价：吉</div>
                            <p class='poem'>丁运本是正财乡，太公八十遇文王。</p>
                            <p class='poem'>八百基业从此起，春来无处不花香。</p>
                            <p class='poem'>未运正官正财位，虽有小危不见亏。</p>
                            <p class='poem'>任君谋为皆称意，只有风云来聚会。</p>
                            <p class='poem'></p>
                            <p>根据你的自身八字信息，你的流年行运非常不错，安定舒适安逸工作环境，高薪水收入，无烦心之事的干扰，且多得贵人长辈或的关心爱护。在社会上容易得名望，容易中榜大学录取公务员，有学习时间或外出进修学习之机会。在走到此大运时，带有权力象徵，好名声，有智慧，被尊重，慈悲慈祥、宽厚，易满足，信任稳重，有宗教心，有修养，待人亲切包容心但喜佔权，易得父母长辈及贵人之助力，生活工作事业或学业安定平顺，名望提升，对宗教感兴趣，心性呈现无我，宽大慈爱之心性，易有创业现象，职位稳定。利于学术研究，并有望获得一定的声望，对学习功名的精力投入较多，易得贵人或长辈的相助，财富收入稳定，有购买房屋车量的信息。</p>";
                        $wenan_sndy_ndfx_arr[2] = "<div class='sub-tit'>当前大运：乙亥运</div>
                            <div class='red2'>综合评价：吉</div>
                            <p class='poem'>已运原是正官会，水多遇土反为贵。</p>
                            <p class='poem'>财旺生官多祥瑞，身弱遇此有刑亏。</p>
                            <p class='poem'>亥运禄堂倒不妨，求谋顺遂大吉昌。</p>
                            <p class='poem'>买臣五十方豪富，太公八十遇文王。</p>
                            <p class='poem'></p>
                            <p>根据你的自身八字信息，你的流年行运非常不错，在这个大运里，你为人忠心、顺从，有理性，诚实，有责任感，头脑好，工作事业稳定，有光明正大的心态，能在事业工作方面取得好成绩，在职位或官位上较易高升，考试较易上榜，官讼较易胜诉，易得长官提拔，自己创业发展空间大，收益丰厚。另一方面，这个大运对于发展人脉关系有利，人人都愿意和你保持良好关系。而且这个大运子女运非常好，单身男性容易找到伴侣，而已婚男士能得到宝宝，和子女相处融合。</p>
                            <div class='sub-tit'>下一个大运：甲寅运（2020年~2029年）</div>
                            <div class='red2'>综合评价：大吉</div>
                            <p class='poem'>甲运食神多不利，虽不刑冲也呕气。</p>
                            <p class='poem'>一夜思想千般计，恼恨命运时不济。</p>
                            <p class='poem'>寅运逢病又不良，失财呕气口舌伤。</p>
                            <p class='poem'>纵然五载无大害，也防尺水起波浪。</p>
                            <p class='poem'></p>
                            <p>行此大运时，生活环境差工作上压力大，朋友之间往来少，心情烦躁性格脾气不好，容易发火冲动与他人发生官非口舌之事，易受人欺负遭小人陷害，。钱财花销大经商者资金周转困难破产。兄弟姐妹易遭刑伤，或兄弟姐妹关系不好。本人喜欢迟睡熬夜生活上无规律，不知节制性生活，或多恶梦睡觉失眠，居家生活环境多吵闹噪音大，易为儿女烦心拖累等。在走到此大运时，带有容易自责，易被中伤，被压迫，会想不开，不服输，易紧张，不被信任，具破坏性，强权、做事强势，具伤害性，猜疑，会与朋友敌对，有恨意，生活有压力，有著做人不是懦夫的特性。易遭意外刑伤，虚耗钱财开销大，外力竞争激烈，较冲动行事，容易与人发生争执，工作事业易失败易週转失灵。女性防感情的烂桃花，或遇小人欺骗。</p>";
                        $wenan_sndy_ndfx_arr[3] = "<div class='sub-tit'>当前大运：壬戌运</div>
                            <div class='red2'>综合评价：吉</div>
                            <p class='poem'>壬运比肩好运来，百事称意则和谐。</p>
                            <p class='poem'>逢春老树多生意，出入常得贵人抬。</p>
                            <p class='poem'>戌运正财偏官地，财喜两旺不须疑。</p>
                            <p class='poem'>时来风送腾王阁，黄鹤楼中吹玉笛。</p>
                            <p class='poem'></p>
                            <p>在走到此大运时，容易获得长辈或贵人之协助，工作事业较安定，愿望顺遂学业平顺，事事亨通，副业易有成就，易接近宗教或文学，喜独处思考但会较孤独，可多利用创造力开发新业务、新產品以生财。安定舒适安逸工作环境，高薪水收入，无烦心之事的干扰，且多得贵人长辈或的关心爱护。在社会上容易得名望，容易中榜大学录取公务员，有学习时间或外出进修学习之机会。利于学业功名，会对学习或思考的精力投入较多，易得贵人或长辈的相助，钱财称心如意，有购买房屋车量的可能。</p>
                            <div class='sub-tit'>下一个大运：戊辰运（2020年~2029年）</div>
                            <div class='red2'>综合评价：大吉</div>
                            <p class='poem'>戊运推来是七煞，是非口舌不可亏。</p>
                            <p class='poem'>纵然五载无进退，事多混杂乱如麻。</p>
                            <p class='poem'>辰运墓库又不逢，花正开放过风隆。</p>
                            <p class='poem'>任你用尽千般计，人争闲气一场空。</p>
                            <p class='poem'></p>
                            <p>行此大运，工作上多忙碌，意气用事与上级或老板容易发生口舌之事，有离职单干的冲动。未婚男女恋爱易生波折，感情不稳定。在走到此大运时，平日生活爱带有爱面子，傲气、自满、自我主张，易有情感因素而產生纠纷，较会自我推销，言词犀利，喜自我主张且不易妥协，重名声，虚荣心强，好胜心强，善变，猜疑的特性，重情感，过份情感用事，女人容易对丈夫不满，男人对工作事业工作不顺，任性，多小人是非，说话伤人，得罪他人，容易受子女或部属之连累，或為部属或子女事而烦忧等等。付出较多，辛苦劳累而收获不大，容易不服管教，易犯官非和小人，感情易有第三者影响，女命遇之不宜本年结婚成家。</p>";

                        $wenan_zjjy_arr[0] = "<p>1、四柱喜金，有利的方位是西方，不利南方，东南；其人喜白色，不利红色，喜居住坐西朝东的房子，床的放置东西向，床头在西。</p>
                              <p>2、取名用字五行属金的有利。</p>
                              <p>3、四柱喜金，应从事与金有关的事业或职业为宜，如经营五金器材，粗铁材或金属工具材料等方面事业，坚硬事业、决断事业、主动别人性质的事业，一切武术家、鉴定师（评估师）、拍卖人员、法官、执法人员、总主宰、汽车界、交通界、金融界、工程业、科学界、武术家、开矿界、民意代表、珠宝界、伐木事业。</p>
                              <p>4、事业发展利西、中西, 不利南、东南</p>
                              <p>5、吉祥数字为：7,8</p>
                              <p>6、吉利楼层末位数为：4,6</p>";

                        $wenan_zjjy_arr[1] = "<p>1、喜用神为水，你的有利的方位是北方（以父出生地为基准），不利西南；其人喜黑色，不利红色，黄色，喜居住座北超南的房子，床的放置南北向，床头在北，名字加水字旁有利。（喜忌所涉及的五行、方位、颜色等尽可能涉及到生活中的方方面面）。</p>
                              <p>2、取名用字五行属水的有利。</p>
                              <p>3、四柱喜水，应以从事有关水的事业或职业为宜，漂游性质、奔波性质、流动性质、连续运动性质、易变化性质、水属性质、音响性质、清洁性质、冷温具不燃性之化学界，靠入海求生活者，均属之。航海界、（船员也是），冷温不燃液体，冰水界、鱼类界、水产界、水利界、水物界、冷藏界、冷冻界、打水界、洁洗业、扫除业、流水界、港内界、泳池、湖、池塘、浴池，菜市场内售买冷食物（鱼、肉……豆腐）均属之。迁旅业、特技表演业、运动家、导游业、旅行业售卖、玩具业、声乐音响业、魔术、马戏团、采访记者、侦探、旅社、或灭火器具、钓鱼器具均属之。</p>
                              <p>4、事业发展利北，不利中、南。</p>
                              <p>5、吉祥数字为：2,4</p>
                              <p>6、吉利楼层末位数为：1,8</p>";
                        $wenan_zjjy_arr[2] = "<p>1、喜用神为木，你的有利的方位是东方（以父出生地为基准），不利西方，西南；其人喜绿色，不利白色，喜居住坐东朝西的房子，床的放置东西向，床头在东，名字加木字旁有利，房间里适宜摆放绿色植物。（喜忌所涉及的五行、方位、颜色等尽可能涉及到生活中的方方面面）</p>
                              <p>2、取名用字五行属木的有利。</p>
                              <p>3、四柱喜木，应从事与木有关的事业或职业为宜，文学、文艺、文具店、文化事业的文人，教育界、书店、出版社、公务界、政治、工商、医务、宗教、司法界、治安警界、官途之界、政治界、新创设计、特殊动植物生长界之学者、植物载种试验界。木材、木器、木制品、家具、装璜、纸界、竹界、种植界、花界、树苗界、青果商、草界、药物界（开药房或药剂师）、医疗界。培育人才界、布匹买卖界、售敬神物品或香料界、宗教应用物界、宗教家之事业、或售卖植物性之素食品，以上均属木之事业。</p>
                              <p>4、事业发展利东、东北，不利西、西南。</p>
                              <p>5、吉祥数字为：3,6</p>
                              <p>6、吉利楼层末位数为：6,8</p>";
                        $wenan_zjjy_arr[3] = "<p>1、喜用神为火，你的有利的方位是南方（以父出生地为基准），不利北方，西北；其人喜红色，不利黑色，喜居住坐南朝北的房子，床的放置南北向，床头在南，名字加火字旁有利。（喜忌所涉及的五行、方位、颜色等尽可能涉及到生活中的方方面面）</p>
                              <p>2、取名用字五行属火的有利。</p>
                              <p>3、四柱喜火，应从事与火有关的事业或职业为宜，热度性质、火爆性质、光线性质、加工修理性质、做工性质、易燃性质、手工艺性质、一切人身装饰物性质，均属之。放光、照光、照明、光学、高热、液热、易燃烧物。或油类界、酒类界、热饮食界、食品界、手工艺口、机械加工品。工厂、制造厂、衣帽行、理发馆、化学界、一切人生装饰物品。军界、歌舞艺术（以人对人之事业）、百货行、印刷业、雕刻师、评论家、心理学家、演说家均属之。
事业发展利南、东南，不利北、西北。</p>
                              <p>5、吉祥数字为：5,7</p>
                              <p>6、吉利楼层末位数为：2,9</p>";
                        $wenan_swkyf_arr[0] = " <p>都说爱笑的人运气不会太差，正面的心态笑对生活，能给自己带来好的运势。然而大家又是否知道，其实食物对于我们来说，都有非常好的开运作用。每个人都有自己喜欢和不喜欢的颜色。通过食物把不同的色彩带入我们的生活当中，不同的生肖属性的人士通过吃不同颜色的食物，可以令个人运势起到好的改变。</p>
                              <p>你的生肖兔五行属木，五行定律中木生火。所以属兔的人士，若想提升个人运势，可多吃红色或紫色的食物或蔬菜。通过吃这些食物可以旺运，例如多吃草莓、樱桃、红萝卜、灯笼椒、西红柿、辣椒、提子、茄瓜等。或者是一些红色的蔬菜都可以进行选择，亦能够很好地增强自身的运势。红色食物一般含有丰富的矿物质，并且可提供丰富的蛋白质来源，有利于增添活力。缺乏红色食品，人体就会容易出现能量下降及缺乏耐性。而紫色的食物则较红色食物少见。</p>";
                        $wenan_swkyf_arr[1] = " <p>在八字五行学当中，并不是所有人都具备完整的五行，我们有部分一出生就缺五行，就是所谓的五行不完整。通过食物，对自身进行五行协调平衡，可以令个人运势起到好的改变。</p>
                              <p>您的五行缺木，依照五行的观点，绝大多数的素食都属木。对于八字中缺木的人来说，多吃素菜无论是对健康还是对学业事业都会起到很大的帮助。在所有的豆类中，绿豆是典型的木性食物，夏天用其来制作绿豆汤或是绿豆芽，不仅可以清热祛暑，温润脾肺，还能补木旺运。另外，在蔬菜方面，白菜、荠菜、椰菜、菠菜、油麦菜、萝卜、韭菜、莲藕等都是属木，而就水果来说，苹果、橙子、马蹄、杨桃、柚子、梨子、梅子、核桃等也都属木，都可以为八字缺木的人带来一定的生旺效果。</p>";
                        $wenan_swkyf_arr[2] = " <p>在八字五行学当中，并不是所有人都具备完整的五行，我们有部分一出生就缺五行，就是所谓的五行不完整。通过食物，对自身进行五行协调平衡，可以令个人运势起到好的改变。</p>
                              <p>您的五行缺火，对于八字中缺火的人来说，辣椒、番茄、胡萝卜、茄子、榴莲、荔枝、龙眼、火龙果等这些蔬菜水果都可以多吃。食用素菜时可能要稍微注意一下加工方法，不宜做成蔬菜沙拉或是直接用白水焯了吃，虽然从营养的角度来讲这样做可以减少营养成分的流失，却不利于运势。最好的方法是用姜片来爆炒，因为姜、葱都是属于非常好的补火的菜品作料。出此之外，还可以尝试着在炒菜时多加入辣椒、花椒、八角和咖喱等调味品，也能起到生旺惑星能量的效果。豆类方面，红豆也是属火的。口味稍重的，不妨多吃些川菜、湖南菜、泰国菜和韩国的辣泡菜，这些以辣味为主的菜系也都是很好的进步火性能量的菜品。</p>";
                        $wenan_swkyf_arr[3] = " <p>在八字五行学当中，并不是所有人都具备完整的五行，我们有部分一出生就缺五行，就是所谓的五行不完整。通过食物，对自身进行五行协调平衡，可以令个人运势起到好的改变。</p>
                              <p>您的五行缺土，对于五行缺土的人来说，牛肉是不错的选择，多吃牛肉、牛腩等都可以起到补土运的作用。羊肉、狗肉以及一切的瘦肉也都是土性的食物，不妨可以多吃点，但是需要注意食用的季节，防止因为羊肉和狗肉的燥热引起上火。   另外，木瓜、栗子和花生也是土性的食物，也可以弥补孩子八字五行缺土的问题，帮助提高运势。</p>";
                        //返回随机数组键名
                        $rand_key = array_rand($wenan_sndy_ndfx_arr,1);
                        $cyxp_data['wenan_sndy_ndfx_arr'] = $wenan_sndy_ndfx_arr[$rand_key];
                        $cyxp_data['wenan_zjjy_arr'] = $wenan_zjjy_arr[$rand_key];
                        $cyxp_data['wenan_swkyf_arr'] = $wenan_swkyf_arr[$rand_key];
                        $this->return_format(1,'测算成功',$cyxp_data);
                    }
                }else{
                    $this->return_format(10002,'订单不存在',[]);
                }
            }
        }catch (\Exception $e){
            $this->return_format(10004,$e -> getMessage());
        }
    }


    /**
     * 测算类所有支付
     * @param  pay_type=1 微信支付  pay_type=2 支付宝支付
     */
    public function payAction(){
		header('Access-Control-Allow-Origin:*');
        $data = (new PayValidate())->go_check();

        file_put_contents(\Phalcon\DI::getDefault()->get("global_config")->log->new_pay_log_path ."/huiyuan/".date('Ymd', time())."/ts_data100.log", var_export($data,true)."\r\n", FILE_APPEND);


        $SmOrderModel = new \Yw11smorders();
        $order_info = $SmOrderModel -> get_record_by_oid($data['order_sn']);
        $packet_id   = $this -> post_params('packet_id','int',0);
        $red_money = 0;
        if($order_info){
            // 红包优惠卷使用
            if($packet_id){
                $packet = \Packet::findFirst(array(
                    "conditions" => "packet_id = :packet_id: and open_id = :open_id: and module_type=80 and is_used !=1 and overdue_time> ". time(),
                    "bind" => array('packet_id' => $packet_id, 'open_id'=>$data['openid']),
                ));
                if($packet){
                    if($packet->is_used==2){
                        $red_money = $packet->money;
                    }elseif($packet->is_used==3){
                        // 锁定中的优惠卷,只有同类的测算还可以使用
                        $red_order_info = \Yw11smorders::findFirst("id = ".$packet->order_id);
                        if($red_order_info && $red_order_info->type == $order_info['type']){
                            $red_money = $packet->money;
                        }
                    }
                }
            }

            $SmOrderModel -> id = $order_info['id'];
            $up_data = ['paytype'=>$data['pay_type']];
            if($red_money){
                if(($this->money - $red_money) > ($order_info['money'] - $red_money)){
                    $up_data['money'] = $order_info['money'];
                }else{
                    $up_data['money'] = $order_info['money'] - $red_money;
                }
                $up_data['packet_id'] = $packet_id;
                $order_info['money'] = $up_data['money'];
            }
            if ($order_info['open_id'] == 'oKZ0PwwL4alWSJEQdto0xUAGBs9U') {
                $order_info['money'] = 0.01;
                $up_data['money'] = 0.01;
            }
            //修改该订单支付方式
            $SmOrderModel->iupdate($up_data);
            $result = $this -> get_h5_code($order_info,$data['pay_type'],$data['openid']);
            if($result){
                $return_data=[
                    'result'=>$result,
                    'data'=>$data
                ];

                $this -> return_format(1,'成功',$return_data);
            }else{
                $this->return_format(1,'订单支付异常');
            }
        }else{
            $this->return_format(1,'该订单不存在');
        }

    }

    /**
     * 获取支付链接
     * @param $order_info  订单表信息
     * @param $pay_info    订单支付表信息
     * @param $pay_code    支付方式
     * pay_type=1 微信支付  pay_type=2 支付宝支付
     * @return bool
     */
    private function get_h5_code($order_info,$pay_type,$openid)
    {
        if( !$order_info || empty($pay_type) ) {
            $this->return_format(10004,'支付参数缺失!');
        }

        $title = $this->get_type($order_info['type']);
        $action = $this->get_action($order_info['type']);

        $pay_params = array();
        if( $pay_type == 2 ) {
            $payment = new \Alipayh5Helpers();
            $pay_params['title']    = $title.'费用';
            $pay_params['money']    = $order_info['money'];
            $pay_params['pay_sn']   = $order_info['oid'];
            $pay_params['pay_type'] = '10006';
            $pay_params['module_type'] = 80;//80--八字合婚支付
            $pay_params['action'] = $action;
        } else {
            //匹配获取pay_code
            $new_pay_code = \StringHelpers::get_PayCode(USER_FROM);

            $type=0;
            if($new_pay_code == 10003){
                $new_pay_code = "APP";
                $pay_params['appid'] = 'wxd5d842eb3d9189cc';
                $pay_params['mch_id'] = '1426331902';
                $type = 1;
            }

            $payment = new \WechatpayHelpers();
            $pay_params['title']    = $title.'费用';
            $pay_params['money']    = $order_info['money'];
            if($this -> token == "oKZ0Pw_bIw60nTXeLZ6yEAxHGVmI" || $this->token == "oKZ0Pw6UaxOJj1IWQMwJn4pVXUIY" || $this->token == "oKZ0Pw7GGvHPFq8CS0bSQX7BLIQc" || $this->token == "oKZ0Pw_bIw60nTXeLZ6yEAxHGVmI"){
                $pay_params['money']    = 0.01;
            }
            //每次传给微信的商户订单号不能重复
            $pay_params['pay_sn']   = $order_info['oid'];
//            $pay_params['pay_sn']   = $order_info['oid']."_".$this->getRandChar(6);
            $pay_params['pay_type'] = $new_pay_code;
            $pay_params['order_sn'] = $order_info['oid'];
            $pay_params['is_xcx'] = false;
            $pay_params['module_type'] = 80;//80--八字合婚支付
            $pay_params['action'] = $action;
            $pay_params['token'] = $this->token;
            if( $openid ) {
                $pay_params['openid'] = $openid;
            }
        }
        file_put_contents(\Phalcon\DI::getDefault()->get("global_config")->log->new_pay_log_path ."/huiyuan/".date('Ymd', time())."/ts_data100.log", var_export($pay_params,true)."\r\n", FILE_APPEND);

        $result = $payment->get_code($pay_params,$type);

        file_put_contents(\Phalcon\DI::getDefault()->get("global_config")->log->new_pay_log_path ."/huiyuan/".date('Ymd', time())."/ts_data100.log", var_export($result,true)."\r\n", FILE_APPEND);

        return $result;

    }

    /**
     * @param string $length 指定随机码长度
     * @return mixed 返回几乎不重复的随机串
     */
    private function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0;
             $i < $length;
             $i++) {
            $str .= $strPol[rand(0, $max)];
        }
        return $str;
    }





    private function get_type($type){
        switch($type) {
            case 1:
                $title = "八字精批";
                break;
            case 2:
                $title = "八字合婚";
                break;
            case 3:
                $title = "姓名分析";
                break;
            case 4:
                $title = "姓名配对";
                break;
            case 5:
                $title = "紫薇排盘";
                break;
            case 6:
                $title = "桃花运";
                break;
            case 7:
                $title = "月老姻缘";
                break;
            case 8:
                $title = "财运详匹";
                break;
            case 9:
                $title = "十年大运";
                break;
            default:
                $title = "其他";
                break;
        }

        return  $title;
    }

    private function get_action($type){
        switch($type) {
            case 1:
                $action = "bazijp";
                break;
            case 2:
                $action = "hehun";
                break;
            case 3:
                $action = "xmfx";
                break;
            case 4:
                $action = "xmpd";
                break;
            case 5:
                $action = "zwpp";
                break;
            case 6:
                $action = "bzyy";
                break;
            case 7:
                $action = "yinyuancs";
                break;
            case 8:
                $action = "cyxp";
                break;
            case 9:
                $action = "sndy";
                break;
            default:
                $action = "index";
                break;
        }
        return  $action;
    }

    /**
     * 根据token获取当前用户订单信息
     */
    public function get_orderAction(){
        header('Access-Control-Allow-Origin:*');
        //根据用户的open_id获取
        $open_id = $this -> token;
        $member_orders = \Yw11smorders::find([
            "conditions"=>"open_id = :openid:",
            "bind"=>['openid'=>$open_id],
            "order" => "createtime DESC"
        ])->toArray();
        if($member_orders){
            foreach ($member_orders as $key=>$val){
                $member_orders[$key]['type'] = $this->get_action($val['type']);
            }
            $this->return_format(1,"成功",$member_orders);
        }else{
            $this->return_format(1,"抱歉,当前没有订单数据",[]);
        }
//        if($this->redisModel->exists($this->token) && $this->redisModel->ttl($this->token)){
//            if($member_orders = $this->redisModel->get($this->token)){
//                $this->return_format(1,"成功",$member_orders);
//            }else{
//                $this->return_format(1,"抱歉,当前没有订单数据",[]);
//            }
//        }else{
//            $this->return_format(30000,"token令牌已失效或者不存在");
//        }
    }

    /**
     * 存对应token令牌的订单数据到redis
     * 数据根据订单号下标追加数据
     * 如果订单号相同则覆写原来数据信息
     */
    protected function save_order_redis($token,$data=[]){
        //先查找redis原数据
        /** 验证token令牌的有效性 */
        if($this->redisModel->exists($token) && $this->redisModel->ttl($token)){
            if($member_orders = $this->redisModel->get($token)){
                $new_redis_arr = array_merge($member_orders,$data);
                $this->redisModel->set($token,$new_redis_arr);
            }else{
                $this->redisModel->set($token,$data);
            }
        }

    }

    protected function get_order_redis($token){

            return $redis_arr = $this->redisModel->get($token);

    }
    /**
     * 姓氏处理函数
     * @param $name  张迪
     * @return bool
     */
    private function t4($name) {

        $first_name_list = \FirstName::find(array(
            "order" => "word_length desc"
        ))->toArray();
        $first_name_list = array_column($first_name_list, "first_name");
        foreach ($first_name_list as $val) {
            $temp = preg_replace('/^'.$val.'/', '', $name);
            $name_len = mb_strlen($name, 'utf8');


            if (mb_strlen($temp, 'utf8') != mb_strlen($name, 'utf8') && mb_strlen($name, 'utf8') < 5 && mb_strlen($name, 'utf8') > 1) {
                if ($name_len == 4 && mb_strlen($val, 'utf8') == 1) {
                    continue;
                }
                return $val;
            }
        }
        return false;
    }
    /**
     * 优惠卷查询
     */
    function redpacketAction(){
        // header('Access-Control-Allow-Origin:360nbc.com');
		header('Access-Control-Allow-Origin:*');
        $openid = $this -> post_params('open_id','remove_xss');
        $appflag   = $this->post_params('appflag','string','');     //小程序标志
        $type   = $this -> post_params('type','int',0);
        if(empty($openid))
            $this->return_format(10005, '缺少参数');
        $return_data = [];
        $packet = \Packet::findFirst(array(
            "conditions" => "open_id = :open_id: AND appflag = :appflag: and module_type=80 and is_used !=1 and overdue_time> ". time(),
            "bind" => array('open_id' => $openid, 'appflag' => $appflag),
        ));

        $return_data = array();

        if($packet){
            if($packet->is_used==2){
                $return_data['packet_id'] = $packet->packet_id;
                $return_data['money'] = $packet->money;
                $return_data['overdue_time'] = date('Y-m-d H:i', $packet->overdue_time);
            }elseif($packet->is_used==3){
                // 锁定中的优惠卷,只有同类的测算还可以使用
                $order_info = \Yw11smorders::findFirst("id = ".$packet->order_id);
                if($order_info && $order_info->type == $type){
                    $return_data['packet_id'] = $packet->packet_id;
                    $return_data['money'] = $packet->money;
                    $return_data['overdue_time'] = date('Y-m-d H:i', $packet->overdue_time);
                }
            }
        }
        $return_data || $return_data = (object) array();
        echo json_encode(['code'=>1,'msg'=>'成功','data'=>$return_data]);
        exit;
    }
}
