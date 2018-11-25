const assert = require('assert');

let MobileBGCarExampleHTML = `
<table class="tablereset" style="width:660px; margin-bottom:0px; border-top:#008FC6 1px solid;">
    <tbody> 
        <tr>
            <td style="width:150px;height:10px;"></td>
            <td style="width:232px;height:10px;"></td>
            <td style="width:135px;height:10px;"></td>
            <td style="width:37px;height:10px;"></td>
            <td style="width:106px;height:10px;"></td>
        </tr>
        <tr>
            <td rowspan="2" style="width:150px;height:90px">
            <table class="tablereset" style="width:132px">
                <tbody>
                <tr>
                    <td class="algcent valgmid">
                        <a href="//www.mobile.bg/pcgi/mobile.cgi?act=4&amp;adv=11543164897547470&amp;slink=8w1id2" class="photoLink">
                        <img src="//sc01-ha-b.mobile.bg/photos/1/med/11543164897547470_1.pic" width="120" height="90" class="noborder" alt="Обява за продажба на BMW 530 XD ~13 500 лв." data-geo="">
                        </a>
                    </td>
                </tr>
              </tbody>
            </table>
            </td>
            <td class="valgtop" style="width:232px;height:40px;padding-left:4px">
                <a href="//www.mobile.bg/pcgi/mobile.cgi?act=4&adv=11543164897547470&amp;slink=8w1id2" class="mmm">BMW 530 XD</a><br><img src="//www.mobile.bg/images/picturess/no.gif" width="1" height="15" class="noborder" alt=""><span style="font-size:10px; color:FF0000;">/нова обява/</span>
            </td>
                <td class="algright valgtop" style="width:135px;height:40px;padding-left:4px">
                <span class="price">13 500 лв.</span>&nbsp;
            </td>
            <td class="valgtop" style="width:37px;height:40px">
                <a href="javascript:;" id="star_11543164897547470" onclick="javascript:openLogPopup(1); return false;" title="Добави обявата в бележника. Изисква регистрация." class="favListItem"></a>
            </td>
            <td class="valgtop algright" style="width:106px;height:40px">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="4" style="width:510px;height:50px;padding-left:4px">
                дата на произв. - януари 2008 г., пробег - 270000 км, цвят - Тъмно син мет., S2NPA BMW М ляти джанти + зимни гуми с ляти джанти...<br>Особености - 4(5) Врати, 4x4, Auto Start Stop function, DV...<br>Регион: София, гр. София
            </td>
        </tr>
        <tr><td colspan="5" style="height:5px;"></td></tr>
        <tr>
            <td colspan="2" style="padding-left:4px">
                <a href="//www.mobile.bg/pcgi/mobile.cgi?act=4&amp;adv=11543164897547470&amp;slink=8w1id2" class="mmm1">Повече детайли и 9 снимки</a> | <a href="javascript:;" id="notepad_11543164897547470" onclick="javascript:openLogPopup(1); return false;" title="Добави обявата в бележника. Изисква регистрация." class="mmm1">Добави в бележника</a>
            </td>
            <td colspan="3" class="algright">
                <a href="javascript:;" id="mark_p11543164897547470" onclick="javascript:mark('mark_p11543164897547470',p11543164897547470); updatecomprint('p11543164897547470','11543164897547470_1.pic');" class="mmm1">Маркирай обявата</a>
                <img name="p11543164897547470" src="//www.mobile.bg/images/picturess/print_n.gif" width="15" height="15" class="noborder" alt="МАРКИРАЙ ОБЯВАТА" onclick="javascript:mark('mark_p11543164897547470',p11543164897547470); updatecomprint('p11543164897547470','11543164897547470_1.pic');"><img src="//www.mobile.bg/images/picturess/no.gif" width="4" height="1" class="noborder" alt="">
            </td>
        </tr>
        <tr>
            <td colspan="5" style="height:10px;"></td>
        </tr>
    </tbody>
</table>`;

const MobileBGReducer = require('../../app/Reducers').MobileBG;
const Reducer = new MobileBGReducer(MobileBGCarExampleHTML);

describe('it should get all car information from given html', function() {
    it('gets title of the car', function() {
        assert.equal(Reducer.title, 'BMW 530 XD');
    });
    
    it('gets the description of the car', function() {
        assert.equal(Reducer.desc, 'дата на произв. - януари 2008 г., пробег - 270000 км, цвят - Тъмно син мет., S2NPA BMW М ляти джанти + зимни гуми с ляти джанти...<br>Особености - 4(5) Врати, 4x4, Auto Start Stop function, DV...<br>Регион: София, гр. София');
    });

    it('gets the image of the car', function() {
        assert.equal(Reducer.image, 'sc01-ha-b.mobile.bg/photos/1/med/11543164897547470_1.pic');
    });

    it("gets the link for the car ad", function() {
        assert.equal(Reducer.link, 'www.mobile.bg/pcgi/mobile.cgi?act=4&adv=11543164897547470');
    });

    it("get the price for the car", function() {
        assert.equal(Reducer.price, '13 500 лв.');
    })
});
