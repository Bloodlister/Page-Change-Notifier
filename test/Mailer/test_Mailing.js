const assert = require('assert');
const MobileBGMailer = require('./../../app/Mailing.js').MobileBG;

let html = `
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Demystifying Email Design</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<h1 style="color:yellow">This is a testaroo</h1>
</body>
</html>
`;

describe('Sending email', () => {
    it('Sends emails with styling', (done) => {
        MobileBGMailer.sendMail('bloodlisterer@gmail.com', html).then(result => {
            done();
        });
    })
})