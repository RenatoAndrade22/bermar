const puppeteer = require('puppeteer');

async function clickAndWaitForSelector(page, selector, delay = 0) {

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

(async () => {
  const browser = await puppeteer.launch(
    {
        headless: false,
        args: ['--user-agent=Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36'],
        userDataDir: './session'
    }
  );
  const page = await browser.newPage();


    // Substitua 'http://localhost:8000' pela URL local do seu aplicativo Laravel
    await page.goto('http://bermar.local/');

    await clickAndWaitForSelector(page, '#entrar');

    await typeInInput(page, '#form-login-email', 'admin@bermar.com.br');

    await typeInInput(page, '#form-login-password', '123123');

    await clickAndWaitForSelector(page, '#form-login-btn');

    await clickAndWaitForSelector(page, '#get-data-api', 3000);
    
    await waitForSelectorWithTimeout(page, '#importado-com-sucesso', 120000);
    
    console.log('passou');



  //    await browser.close();

})();
