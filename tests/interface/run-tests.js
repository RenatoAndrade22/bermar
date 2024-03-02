const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch(
    {
        headless: false,
        args: ['--user-agent=Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36'],
        userDataDir: './session'
    }
  );

  const page = await browser.newPage();
  
  await loginTest(page);

  // await homeTest(page);

  await produtosTest(page);

  console.log('passou aq');

  

  //    await browser.close();

})();

async function clickAndWaitForSelector(page, selector, delay = 2000) {

  if(delay > 0){
      await new Promise(resolve => setTimeout(resolve, delay));
  }
  await page.waitForSelector(selector);
  await page.click(selector);
}

async function typeInInput(page, selector, text) {
  await page.waitForSelector(selector);
  await page.type(selector, text);
}

// Função reutilizável para esperar por um seletor com um timeout personalizado
async function waitForSelectorWithTimeout(page, selector, timeout) {
  try {
    await page.waitForSelector(selector, { timeout });
  } catch (error) {
    throw new Error(`Timeout: Elemento ${selector} não encontrado após ${timeout / 1000} segundos.`);
  }
}

async function loginTest(page){
  
  // Substitua 'http://localhost:8000' pela URL local do seu aplicativo Laravel
  await page.goto('http://bermar.local/');

  await clickAndWaitForSelector(page, '#entrar');

  await typeInInput(page, '#form-login-email', 'admin@bermar.com.br');

  await typeInInput(page, '#form-login-password', '123123');

  await clickAndWaitForSelector(page, '#form-login-btn');

  await new Promise(resolve => setTimeout(resolve, 3000));
}

async function produtosTest(page) {
  await clickAndWaitForSelector(page, '#nav-produtos');
  //await clickAndWaitForSelector(page, '#cadastrar-produto');
}

async function homeTest(page) {

  const path = require('path');

  const filePath = path.relative(process.cwd(), __dirname + '/myPDF.pdf');

  // Abra a página onde você precisa fazer o upload

  // Desative o diálogo de seleção de arquivo nativo
  await page.setExtraHTTPHeaders({ 'Accept-Language': 'en-US,en;q=0.9' });

  // Selecione o input de arquivo e faça o upload
  const input = await page.$('input[name=catalog]');
  await input.uploadFile(filePath);

  await clickAndWaitForSelector(page, '#enviar-catalogo');

  await page.waitForSelector('.vs-noti-success', { hidden: true, timeout: 12000 });

  await new Promise(resolve => setTimeout(resolve, 10000));

  await clickAndWaitForSelector(page, '#get-data-api', 3000);
  
  await waitForSelectorWithTimeout(page, '.vs-noti-success', 90000);

}
