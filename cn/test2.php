<?php
/*
$data1 = array(
    'id' => 'MEB001',
    'category_id'  => 'MEBOOKS',
    'name' => array('en' => 'Book1'),
    'price' => 2.99,
    'credit' => 30,
    'description' => array('en'=>'A nice book'),
    'discount' => 1.0,
   	'type' => 'MEB',
   	'cover_image_url' => 'mebooks1.png',
   	'status' => 7,
   	'version' => 1,
   	'data' => null,
   	'favorite' => 0
);

$data2 = array(
    'id' => 'MEB002',
    'category_id'  => 'MEBOOKS',
    'name' => array('en' => 'Book2'),
    'price' => 2.99,
    'credit' => 30,
    'description' => array('en'=>'A nice book 2'),
    'discount' => 1.0,
   	'type' => 'MEB',
   	'cover_image_url' => 'mebooks2.png',
   	'status' => 7,
   	'version' => 1,
   	'data' => null,
   	'favorite' => 0
);

$data = array($data1,$data2);

$json = json_encode($data);
echo $json;
*/
/*
$date1 = new DateTime();
$date2 = new DateTime("20140811123249");
$interval = $date1->diff($date2);
echo "<p>difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
echo "<p>difference " . $interval->days; 
*/
include('inc.php');	
$sql = "insert into `school`.`articles` ( `content`, `pub_date`, `title`, `image`, `tag`, `last_updated`, `type`, `description`) values ( '宝宝好动，往往一不小心就受伤。「撞断牙」对宝宝来说，不算是种罕见的伤害。在恒齿尚未长出来之前，撞断乳牙的宝宝还不须制作假牙，但宝宝发生此意外时，爸爸妈妈应如何处理，才能使伤害减到最小的程度呢？以下提供几个观念给家长参考。

用纱布止血，并根据情况决定保留断齿与否
  宝宝撞断牙齿流血时，可以用干净的纱布压迫止血，并尽早就医。撞断的乳牙，要根据断的情形和严重程度，来决定是否保留。如果只有轻微的缺角，就可以保留，但若是牙齿松动，或是往后可能会出现牙髓组织坏死的情形时，则需要拔牙，以避免对发育中的恒牙造成伤害。

牙齿摇摇欲坠，医师决定是否拔除
  摇摇欲坠的乳牙对于宝宝来说一定会造成疼痛，建议由牙医师来评估，另外是否有软组织的伤害或骨头的断裂，也是需要医师来诊断的。

  只要不是硬组织的就是软组织，硬组织是指牙齿、骨头，而牙龈、肌肉、舌头、皮肤、黏膜等等都是软组织。常见的软组织伤害，浅一点的就是擦伤，深一点到表皮以下的伤害，称为撕裂伤。处理这些伤口第一步要先把伤口上的脏东西(如：泥土沙子)冲洗干净，再把已经受损烂掉，会影响愈合的组织剪掉或切掉。撕裂伤必须缝起来，擦伤则保持干净，待其自然愈合即可。

  一般撞到牙齿引起的骨头断裂有两类，一个是齿槽骨断裂，另一个是上下颚的骨头断裂。牙龈内包围着牙齿的骨头称为齿槽骨，齿槽骨断裂，通常将牙齿复位并固定即可。若是颚骨的断裂，就必须交给口腔外科医师，以手术方式处理。

撞断牙齿须尽快就医
  宝宝的乳牙撞断了，不理它绝对不是明智之举。宝宝发生乳牙撞伤，除了立即看到的问题，例如嘴唇，牙龈、舌头、唇系带撕裂伤或是骨头断裂以外，后续还可能会有牙齿变色、牙髓组织坏死，甚至影响到后续恒牙的生长发育。所以，宝宝如果不小心撞断乳牙，爸爸妈妈一定要带他就医。医师除了处理目前可见的伤害，也必须做日后的追踪，让宝宝保有一口健健康康的好牙。
', '2014-10-30', '宝宝撞断乳牙该如何处理？', '', '医疗', '2014-10-30 18:14:41', 'REC', '在恒齿尚未长出来之前，撞断乳牙的宝宝还不须制作假牙。');";
M()->execute($sql);
?>