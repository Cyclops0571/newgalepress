<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>
<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>GalePress Shop</title>
    <meta name="keywords" content="Gale Press, Paketler"/>
    <meta name="description" content="Gale Press paket bilgilerinin bulunduğu sayfa.">
    <meta name="author" content="Gale Press">
    <link type="text/css" media="all" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          rel="stylesheet"/>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
/** @var App\Models\Qrcode $qrCode */
/** @var App\Models\City[] $city */
?>
<div class="container">
    <div class="col-md-12">
        <form method="post">
            {{csrf_field()}}
            <input type="hidden" name="callback" value="<?php echo $cb; ?>"/>
            <input type="hidden" name="qrCodeClientId" value="<?php echo $id; ?>"/>
            <input type="hidden" name="price" value="<?php echo $price; ?>"/>
            <input type="hidden" name="pm" value="<?php echo $pm; ?>"/>
            <h3 class="col-xs-12">Fatura Bilgileri</h3>
            <div class="form-group">
                <label><h4>Fiyat: <?php echo $price; ?> TL</h4></label>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <input id="nameSurname" class="form-control" maxlength="50" name="name" size="50"
                       type="text" tabindex="1" placeholder="İsim Soyisim" required
                       value="<?php echo $qrCode->Name; ?>"/>
            </div>
            <div class="form-group">
                <input id="email" class="form-control" maxlength="50" name="email" size="50"
                       type="email" tabindex="2" placeholder="Email" required value="<?php echo $qrCode->Email; ?>">
            </div>
            <div class="form-group">
                <input id="phone" pattern="[0-9]{11,11}" name="phone" size="20" type="number" maxlength="11"
                       minlength="11" step="1"
                       class="form-control" tabindex="3" placeholder="Telefon (05XX1234567)" required
                       value="<?php echo $qrCode->Phone; ?>">
            </div>
            <div class="form-group">
                <input class="form-control" id="tc" name="tc" type="number" pattern="[0-9]{11,11}" maxlength="11"
                       minlength="11" step="1"
                       tabindex="3" placeholder="T. C. Kimlik Numarası (12345678910)" required
                       value="<?php echo $qrCode->TcNo; ?>"/>
            </div>
            <div class="form-group">
                <select id="city" class="form-control required" name="city" tabindex="6" required>
                    <?php if(empty($qrCode->City)): ?>
                    <option selected="selected" disabled="disabled">Lütfen Şehir Seçin</option>
                    <?php endif; ?>
                    <?php foreach ($city as $c): ?>
                    <?php $isSelected = $c->CityName == $qrCode->City ? 'selected="selected"' : ''; ?>
                    <option value="<?php echo $c->CityName; ?>" <?php echo $isSelected; ?> >
                        <?php echo $c->CityName; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
            <textarea id="address" class="form-control" maxlength="100" name="address" rows="4"
                      tabindex="6" placeholder="Adres Bilgisi (Sok. No, Konut No)"
                      required><?php echo $qrCode->Address ?></textarea>
            </div>
            <button class="btn btn-primary" id="payBtn" type="submit">Devam Et</button>
        </form>
    </div>
</div>
</body>
</html>