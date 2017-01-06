@layout('website.html')

@section('body-content')
      <section style="background-image: url('/images/website/headers/showcase.jpg');" class="header-section parallax">
        <div class="sep-top-3x sep-bottom-3x">
          <div class="container">
            <div class="section-title upper text-center light sep-top-md sep-bottom-md">
              <h2 class="small-space">{{__('website.menu_showcase')}}</h2>
            </div>
            <div id="filters" class="button-group">
              <button data-filter=".all" class="button is-checked">{{__('website.showcase_filters_all')}}</button>
              <button data-filter=".digitalpublishing" class="button">{{__('website.showcase_filters_digitalpublishing')}}</button>
              <button data-filter=".education" class="button">{{__('website.showcase_filters_education')}}</button>
              <button data-filter=".retail" class="button">{{__('website.showcase_filters_retail')}}</button>
            </div>
          </div>
        </div>
      </section>

      <section style="background:white" class="sep-bottom-2x">
        <div class="container isotope">
           
                <div class="element-item retail">
                  <a target="_blank" href="https://itunes.apple.com/tr/app/carrefoursa/id913201745?mt=8"><img src="/images/website/customers/carrefoursa.png" width="185" /></a>
                </div>


                <div class="element-item">
                  <a target="_blank" href="https://itunes.apple.com/us/app/bigblue/id632025251?mt=8"><img src="/images/website/customers/bigblue.png" width="185" /></a>
                </div>

                <div class="element-item">
                  <a target="_blank" href="https://itunes.apple.com/us/app/bilimteknoloji/id712258171?mt=8"><img src="/images/website/customers/bilimvetekbak.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator1" style="top:380px;"></div>

           
                <div class="element-item">
                  <a target="_blank" href="https://itunes.apple.com/us/app/birka-boya/id675646385?mt=8"><img src="/images/website/customers/birka.png" width="185" /></a>
                </div>

                <div class="element-item">
                  <a target="_blank" href="https://itunes.apple.com/app/id971929270"><img src="/images/website/customers/buyukhun.png" width="185" /></a>
                </div>

                <div class="element-item digitalpublishing">
                  <img src="/images/website/customers/buyukkulup.png" width="185" />
                </div>

                <div class="clientSeperator" id="seperator2" style="top:720px;"></div>

                <div class="element-item">
                  <a target="_blank" href="https://itunes.apple.com/us/app/central-point-fitness/id910158415?mt=8"><img src="/images/website/customers/centralpoint.png" width="185" /></a>
                </div>

                <div class="element-item">
                  <a target="_blank" href="https://itunes.apple.com/ca/app/ac-yap/id967933760?mt=8"><img src="/images/website/customers/coskungrup.png" width="185" /></a>
                </div>

                <div class="element-item realestate">
                  <a target="_blank" href="https://itunes.apple.com/us/app/emlak-pazar/id954300732?mt=8"><img src="/images/website/customers/emlakpazari.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator3" style="top:1060px;"></div>


                <div class="element-item">
                  <a target="_blank" href="https://itunes.apple.com/us/app/enerjisa/id786330938?mt=8"><img src="/images/website/customers/enerjisa.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/ph/app/executive-housekeeper/id858460840?mt=8"><img src="/images/website/customers/exclusivehousekeeper.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/franchise-dunyasi-dergisi/id857852140?mt=8"><img src="/images/website/customers/franchise.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator4" style="top:1400px;"></div>


                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/tr/app/gazetem/id602205559?mt=8"><img src="/images/website/customers/gazete'm.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/genta-tar-m/id945833199?mt=8"><img src="/images/website/customers/gentarim.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/gimdes-helal-sertifika/id858417720?mt=8"><img src="/images/website/customers/gimdes.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator4" style="top:1400px;"></div>


                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/gold-book-magazine/id879049661?mt=8"><img src="/images/website/customers/goldbookmag.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/inciler-grup/id768097839?mt=8"><img src="/images/website/customers/inciler.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/kastamonu-entegre/id791170210?mt=8"><img src="/images/website/customers/kastamonu.png" width="185" /></a>
                </div>

                <div class="clientSeperator" id="seperator5" style="top:1740px;"></div>


                <div class="element-item">
                  <img src="/images/website/customers/kso.png" width="185" />
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/lastik-magazin/id934589157?mt=8"><img src="/images/website/customers/lastikmagazin.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/lazanya-restaurant/id885047529?mt=8"><img src="/images/website/customers/lazanya.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator6" style="top:2080px;"></div>


                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/maryapi/id964296589?mt=8"><img src="/images/website/customers/maryapi.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <img src="/images/website/customers/mies.png" width="185" />
                </div>

                <div class="element-item digitalpublishing">
                  <a target="_blank" href="https://itunes.apple.com/us/app/metal-medya/id922899546?mt=8"><img src="/images/website/customers/mm.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator7" style="top:2420px;"></div>


                <div class="element-item retail">
                  <a target="_blank" href="https://itunes.apple.com/us/app/mopas-market/id955251826?mt=8"><img src="/images/website/customers/mopas.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/mototal/id891286164?mt=8"><img src="/images/website/customers/mototal.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/mototas/id899100430?mt=8"><img src="/images/website/customers/mototas.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator8" style="top:2760px;"></div>
    

                <div class="element-item digitalpublishing">
                  <a target="_blank" href="https://itunes.apple.com/us/app/mpark-dergisi/id768152508?mt=8"><img src="/images/website/customers/m'park.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/nbs-insan-kaynaklar/id853087790?mt=8"><img src="/images/website/customers/nbs.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/oguz-metal/id602583856?mt=8"><img src="/images/website/customers/oguzmetal.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator9" style="top:3100px;"></div>


                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/oruc-market/id945689299?mt=8"><img src="/images/website/customers/oruc.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/pleon-sportivo/id887419281?mt=8"><img src="/images/website/customers/pleon.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/profesyonel-asci/id858577251?mt=8"><img src="/images/website/customers/profesyonelasci.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator10" style="top:3440px;"></div>


                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/re-max-pier/id924224347?mt=8"><img src="/images/website/customers/remax.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/renovia/id913346214?mt=8"><img src="/images/website/customers/renovia.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/restoran-dergisi/id859055714?mt=8"><img src="/images/website/customers/restoran.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator11" style="top:3780px;"></div>


                <div class="element-item all">
                  <img src="/images/website/customers/tatbak.png" width="185" />
                </div>

                <div class="element-item">
                  <a target="_blank" href="https://itunes.apple.com/us/app/tatli-hayat/id859166093?mt=8"><img src="/images/website/customers/tatlihayat.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/teknik-yap/id920623187?mt=8"><img src="/images/website/customers/teknikyapi.png" width="185" /></a>
                </div>


                <div class="clientSeperator" id="seperator12" style="top:4120px;"></div>


                <div class="element-item all">
                  <img src="/images/website/customers/tgsd.png" width="185" />
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/velespit/id920538053?mt=8"><img src="/images/website/customers/velespit.png" width="185" /></a>
                </div>

                <div class="element-item all">
                  <a target="_blank" href="https://itunes.apple.com/us/app/zen-diamond/id640445738?mt=8"><img src="/images/website/customers/zen.png" width="185" /></a>
                </div>

                <div class="clientSeperator" id="seperator13" style="top:4460px;"></div>

<!-- 
                <div class="element-item all">
                  <a target="_blank" href="#"><img src="/images/website/customers/bos.png" width="185" /></a>
                </div>

                <div class="clientSeperator" id="seperator13" style="top:4800px;"></div> -->

        </div>
      </section>

     

@endsection