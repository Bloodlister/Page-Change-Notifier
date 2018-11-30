const assert = require('assert');

let MobileBGCarExampleHTML = `
      <table class="tablereset">
        <tbody><tr>
          <td style="width:150px;height:10px;"></td>
          <td style="width:232px;height:10px;"></td>
          <td style="width:135px;height:10px;"></td>
          <td style="width:37px;height:10px;"></td>
          <td style="width:106px;height:10px;"></td>
        </tr>
        <tr>
          <td rowspan="2" style="width:150px;height:90px">
            
              <table class="tablereset" style="width:132px">
                <tbody><tr>
                  <td class="algcent valgmid"><a href="//www.mobile.bg/pcgi/mobile.cgi?act=4&amp;adv=11509028961101458&amp;slink=8xab7c" class="photoLink"><img src="//sc01-ha-b.mobile.bg/photos/1/med/11509028961101458_5.pic" width="120" height="90" class="noborder" alt="Обява за продажба на Audi A1 1.6TDI 9... ~17 799 лв." data-geo=""></a></td>
                </tr>
              </tbody></table>
              
          </td>
          <td class="valgtop" style="width:232px;height:40px;padding-left:4px">
            <a href="//www.mobile.bg/pcgi/mobile.cgi?act=4&amp;adv=11509028961101458&amp;slink=8xab7c" class="mmm">Audi A1 1.6TDI 9...</a><br><img src="//www.mobile.bg/images/picturess/no.gif" width="1" height="15" class="noborder" alt=""><span style="font-size:10px; color:FF0000;">/нова обява/</span>
          </td>
          <td class="algright valgtop" style="width:135px;height:40px;padding-left:4px">
            <img src="//www.mobile.bg/images/picturess/price-down.png" style="margin-right:3px;"><span class="price">17 799 лв.</span>&nbsp;
          </td>
          <td class="valgtop" style="width:37px;height:40px">
            <a href="javascript:;" id="star_11509028961101458" onclick="javascript:openLogPopup(1); return false;" title="Добави обявата в бележника. Изисква регистрация." class="favListItem"></a>
          </td>
          <td class="valgtop algright" style="width:106px;height:40px">
            <a href="//ilona-stefani.mobile.bg" class="logoLink"><img src="//www.mobile.bg/images/houseslogos/h11706084978382338.pic?15434901085" class="noborder" alt="Лого"></a>
          </td>
        </tr>
        
          <tr>
            <td colspan="3" style="width:404px;height:50px;padding-left:4px">
              дата на произв. - май 2013 г., пробег - 163140 км, цвят - Бял, Перфектно състояние! ! ! Като Нов! ! ! Нов внос; E...<br>Особености - 4(5) Врати, Auto Start Stop function, Bluetoo...<br>Регион: Сливен, гр. Сливен
            </td>
            <td style="width:106px" class="algright"><img src="//www.mobile.bg/images/picturess/vip_sm.gif" width="42" height="42" class="noborder" alt="vip">&nbsp;</td>
          </tr>
          
        
        <tr><td colspan="5" style="height:5px;"></td></tr>
        <tr>
          <td colspan="2" style="padding-left:4px">
            <a href="//www.mobile.bg/pcgi/mobile.cgi?act=4&amp;adv=11509028961101458&amp;slink=8xab7c" class="mmm1">Повече детайли и 16 снимки</a> | <a href="javascript:;" id="notepad_11509028961101458" onclick="javascript:openLogPopup(1); return false;" title="Добави обявата в бележника. Изисква регистрация." class="mmm1">Добави в бележника</a> 
          </td>
          <td colspan="3" class="algright">
            <a href="javascript:;" id="mark_p11509028961101458" onclick="javascript:mark('mark_p11509028961101458',p11509028961101458); updatecomprint('p11509028961101458','11509028961101458_5.pic');" class="mmm1">Маркирай обявата</a>
          <img name="p11509028961101458" src="//www.mobile.bg/images/picturess/print_n.gif" width="15" height="15" class="noborder" alt="МАРКИРАЙ ОБЯВАТА" onclick="javascript:mark('mark_p11509028961101458',p11509028961101458); updatecomprint('p11509028961101458','11509028961101458_5.pic');"><img src="//www.mobile.bg/images/picturess/no.gif" width="4" height="1" class="noborder" alt="">
          </td>
        </tr>
        <tr><td colspan="5" style="height:10px;"></td></tr>
      </tbody></table>`;

const MobileBGReducer = require('../../app/Reducers').MobileBG;
const Reducer = new MobileBGReducer(MobileBGCarExampleHTML);

describe('it should get all car information from given html', function() {
    it('gets title of the car', function() {
        assert.equal(Reducer.title.startsWith('Audi'), true);
    });
    
    it('gets the description of the car', function() {
        assert.equal(Reducer.desc.startsWith('дата на произв'), true);
    });

    it('gets the image of the car', function() {
        assert.equal(Reducer.image.endsWith('.pic'), true);
    });

    it("gets the link for the car ad", function() {
        assert.equal(Reducer.link.startsWith('www.mobile.bg/pcgi'), true);
    });

    it("get the price for the car", function() {
        assert.equal(Reducer.price.endsWith('лв.'), true);
    })
});
