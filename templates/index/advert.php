<div class="container">
    <div class="adverts_box">
        <div class="text-center">
            <h1><?= $data['advert']['data']->advert_title; ?></h1>
        </div>
        <br>
        <div class="col-lg-5">
            <img src="/<?= $data['advert']['data']->image[0]; ?>"/>
            <ul class="min-img">
                <? foreach ($data['advert']['data']->image as $image) { ?>
                <li>
                    <img src="/<?= $image; ?>"/>
                </li>
                <? } ?>
            </ul>
            <div class="col-xs-6"><p class="attr_title">Разместил:</p></div>
            <div class="col-xs-6"><p>
                <?if(!empty($data['advert']['data']->company_name)){
                ?>

                <a href="/company/<?=$data['advert']['data']->company_idcompany?>" class="btn-link"><i class="fa fa-users"></i> <?= $data['advert']['data']->company_name; ?></a>
                <?}else{?>
                <a href="/профиль/<?=$data['advert']['data']->iduser?>" class="btn-link"><i class="fa fa-user"></i> <?= $data['advert']['data']->user_name; ?> <?= $data['advert']['data']->user_surname; ?></a>
                <?}?></p>
            </div>
            <div class="col-xs-12"><p class="attr_title">Контактные данные:</p></div>
            <div class="col-xs-12">
                <?if(!empty($data['advert']['data']->company_name)){
                ?>

                <div class="contact_data  col-xs-12 no_padding"><a id="<?=$data['advert']['data']->company_idcompany?>" class="get_company_contacts_data" onclick="return false" href="#">Показать</a></div>
                <?}else{?>
                <div class="contact_data col-xs-12 no_padding"><a id="<?=$data['advert']['data']->iduser?>" class="get_user_contacts_data" onclick="return false" href="#">Показать</a></div>
                <?}?>
            </div>
            <div class="col-xs-12"><p class="attr_title">Способы доставки:</p></div>
            <div class="col-xs-12">
                <?foreach($data['advert_shipping_types'] as $advert_shipping_type){?>
                <div class="col-xs-12"><?=$advert_shipping_type->shipping_name?></div>
                <?}?>
            </div>
            <div class="col-xs-6"><p class="attr_title">Цена:</p></div>
            <div class="col-xs-6"><p><?= $data['advert']['data']->advert_price ?></p></div>
            <div class="col-xs-6"><p class="attr_title">Дата добавления:</p></div>
            <div class="col-xs-6"><p><?= $data['advert']['data']->advert_date ?></p></div>
        </div>
        <div class="col-lg-7">
            <h3>Описание</h3>

            <p><?= $data['advert']['data']->advert_description; ?></p>

            <h3>Характеристики</h3>

            <div class="col-xs-4 attrs"><p>Категория</p></div>
            <div class="col-xs-8 attrs">
                <a href="/категория<?foreach($data['advert']['path'] as $path){$name = strtr($path->NScat_name, array(" / " => "-", " " => "_")); echo '/'.$name;}?>" class="btn btn-port"><i class="fa fa-tag"></i> <?= $data['advert']['data']->NScat_name; ?></a>

            </div>

            <?php
            foreach ($data['advert']['attributes'] as $attribute) {
                if(!empty($attribute['value'])){
                echo '<div class="col-xs-4 attrs"><p>' . $attribute['NScat_name'] . '</p></div>
        <div class="col-xs-8 attrs"><p>' . $attribute['value'] . '</p></div>';
        }
        }
        ?>



        <div class="col-xs-6"></div>
        <div class="col-xs-6"></div>
    </div>
    <div class="clearfix"></div>
</div>
<?if(isset($data['advert']['edit']) && $data['advert']['edit'] == true){?><a href="/editAdvert/<?=$data['advert']['data']->idadvert?>"> <button class="col-sm-2 advert_action_button"><i class="fa fa-pencil"></i> Редактировать</button></a><?}?>
<div class="clearfix"></div>



<div class="comments">
    <? if(!empty($data['comments']['comments'])){?>

    <div class="text-center">
        <h1>Комментарии</h1>
    </div>
    <br>
    <?
        }
        foreach ($data['comments']['comments'] as $comment) {


            ?>
    <div class="comment  RollInLeft">
        <div class="col-lg-offset-2 col-lg-8">
            <div class="col-sm-3 comment_thumb">
                <img src="<?= $comment->user_img ?>"/>
            </div>
            <div class="col-sm-9 ">
                <h4>Пользователь: <?= $comment->user_name ?></h4> <h5><?= $comment->comments_date ?></h5>

                <div class="clearfix"></div>
                <div class="comment_text">
                    <?= $comment->comments_text ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <? } ?>
    <div class="clearfix"></div>
</div>
<div class="col-xs-12 no_padding" align="center">
    <ul class="pagination pagination-lg">
        <?
            $string_back = '?';
            if(!empty($data['request']['get'])){
                foreach($data['request']['get'] as $key => $var){
        $key = str_replace('?','',$key);
        if($key !=='page'){
        if(is_array($var))
        {
        foreach($var as $value)
        {
        $string_back .= $key;
        $string_back .= '[]';
        $string_back .= '=';
        $string_back .= $value;
        $string_back .= '&';
        }
        }
        else{
        $string_back .= $key;
        $string_back .= '=';
        $string_back .= $var;
        $string_back .= '&';
        }
        }
        }
        }
        if(empty($data['comments']['pagination']['page']))
        $data['comments']['pagination']['page'] = 1;
        $data['comments']['pagination']['limit'] = 20;
        $amount = $data['comments']['pagination']['amount'];
        $page_size = $data['comments']['pagination']['limit'];
        $pages = (integer)($amount/$page_size);
        if($amount%$page_size)
        $pages+=1;
        $max_pages = 3;
        if(isset($data['request']['get']['page']))
        $current_page = $data['request']['get']['page'];
        else
        $current_page = 1;
        if($pages > 1)
        {
        //                   $url .= 'page=';
        if($current_page-$max_pages >= 2){
        echo '<li><a href="'.$string_back.'page=1">Первая</a></li>';
        }
        for($i = $current_page-$max_pages; $i<=$current_page-1; $i++){
        $a=0;
        $a++;
        if($a == $max_pages){break;}
        if($i>0){echo '<li><a href="'.$string_back.'page='.$i.'">'.$i.'</a></li>';}
        }
        echo '<li class="active" ><span>'.$current_page.' <span class="sr-only">(current)</span></span></a></li>';
        for($i = $current_page+1; $i<=$current_page+$max_pages; $i++){
        $a=0;
        $a++;
        if($a == $max_pages || $i > $pages){break;}
        echo '<li><a href="'.$string_back.'page='.$i.'">'.$i.'</a></li>';
        }
        if($current_page+$max_pages < $pages){
        echo '<li><a href="'.$string_back.'page='.$pages.'">Последняя</a></li>';
        }
        }

        ?>
    </ul>
</div>

<div class="comments">
    <div class="text-center">
        <h1>Добавить комментарий</h1>
    </div>
    <div class="comment  RollInLeft" style="<?= $animate ?>">
        <div class="col-lg-offset-3 col-lg-6">
            <div class="col-sm-12">
                <textarea id="comment_text" name="comments_text" rows="5"></textarea>
                <input id="addComment" type="submit" value="Отправить" class="send_button">
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>

</div>
</section>
