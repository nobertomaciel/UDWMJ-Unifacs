async function apicep(cep) { // Função assíncrona que recebe um CEP como parâmetro e retorna os dados correspondentes usando a API ViaCEP
    const url = `https://viacep.com.br/ws/${cep}/json/`;
    try {
        const response = await fetch(url); // Faz uma requisição HTTP para a URL da API ViaCEP usando o método GET e aguarda a resposta
        if (!response.ok) {
            throw new Error('Erro ao buscar o CEP');
        }
        return await response.json(); // Converte a resposta da API para um objeto JavaScript usando o método json() e retorna esse objeto
    } catch (error) {
        alert(error.message);
    }
}
// Adiciona um ouvinte de evento para o campo de entrada do CEP, que é acionado sempre que o usuário digita algo nesse campo. A função anônima passada como segundo argumento é executada toda vez que o evento 'input' ocorre, ou seja, sempre que o valor do campo de entrada é alterado.
document.getElementById('cep').addEventListener('input', async (e) => {
    var cep = e.target.value;// Obtém o valor atual do campo de entrada do CEP usando e.target.value e armazena esse valor na variável cep
    if (cep.length === 9) { // Verifica se o comprimento do valor do CEP é igual a 9 caracteres (formato esperado para um CEP com hífen 99999-999)
        cep = cep.replace(/\D/g, ''); // Remove todos os caracteres não numéricos do valor do CEP usando uma expressão regular e o método replace(), garantindo que o CEP esteja no formato correto para a consulta à API ViaCEP
        const data = await apicep(cep); // Chama a função apicep() passando o valor do CEP sem caracteres não numéricos e aguarda a resposta da API, que é armazenada na variável data
        
        // Abaixo, preenche os campos de entrada com os valores correspondentes retornados pela API ViaCEP, acessando a propriedade do objeto data (passa os valores para os inputs do html, os elementos DOM)
        document.getElementById('logradouro').value = data.logradouro;
        document.getElementById('bairro').value = data.bairro;
        document.getElementById('localidade').value = data.localidade;
        document.getElementById('uf').value = data.uf;
    }
    else {
        // Abaixo, força o formato do CEP enquanto o usuário digita, removendo caracteres não numéricos e inserindo um hífen após os primeiros 5 dígitos, garantindo que o valor do CEP esteja sempre no formato correto (99999-999) durante a digitação
        cep = cep.replace(/\D/g, '');
        cep = cep.substring(0, 8);
        if (cep.length > 5) {
            cep = cep.slice(0, 5) + '-' + cep.slice(5,8);
        }
        e.target.value = cep; // Atualiza o valor do campo de entrada do CEP com o formato corrigido, garantindo que o usuário veja o CEP formatado corretamente enquanto digita
    }
});

function enviarFormulario() { // Função que é chamada quando o formulário é enviado, responsável por coletar os dados dos campos de entrada e enviar esses dados para o servidor usando uma requisição HTTP POST
    
    const url = 'url do seu servidor/'; // Substitua pela URL do seu servidor
    
    // abaixo, obtém os valores dos campos de entrada do formulário usando document.getElementById() e armazena esses valores em variáveis correspondentes (nome, cep, logradouro, bairro, localidade e uf)
    const nome = document.getElementById('nome').value;
    const cep = document.getElementById('cep').value;
    const logradouro = document.getElementById('logradouro').value;
    const bairro = document.getElementById('bairro').value;
    const localidade = document.getElementById('localidade').value;
    const uf = document.getElementById('uf').value;
    
    // abaixo, faz uma requisição HTTP POST para a URL do servidor usando o método fetch(), enviando os dados do formulário no corpo da requisição em formato JSON. O objeto passado para JSON.stringify() contém as chaves e valores correspondentes aos dados coletados dos campos de entrada, que serão processados pelo servidor para inserir esses dados no banco de dados
    fetch(url+'backend_MYSQLCONNECT.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            nome: nome,
            cep: cep,
            logradouro: logradouro,
            bairro: bairro,
            localidade: localidade,
            uf: uf
        })
    });
}