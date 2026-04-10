async function apicep(cep) {
    const url = `https://viacep.com.br/ws/${cep}/json/`;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Erro ao buscar o CEP');
        }
        return await response.json();
    } catch (error) {
        alert(error.message);
    }
}

document.getElementById('cep').addEventListener('input', async (e) => {
    var cep = e.target.value;
    if (cep.length === 9) {
        cep = cep.replace(/\D/g, '');
        const data = await apicep(cep);
        document.getElementById('logradouro').value = data.logradouro;
        document.getElementById('bairro').value = data.bairro;
        document.getElementById('localidade').value = data.localidade;
        document.getElementById('uf').value = data.uf;
    }
    else {
        cep = cep.replace(/\D/g, '');
        cep = cep.substring(0, 8);
        if (cep.length > 5) {
            cep = cep.slice(0, 5) + '-' + cep.slice(5,8);
        }
        e.target.value = cep;
    }
});

function enviarFormulario() {
    const url = 'url do seu servidor/'; // Substitua pela URL do seu servidor
    const nome = document.getElementById('nome').value;
    const cep = document.getElementById('cep').value;
    const logradouro = document.getElementById('logradouro').value;
    const bairro = document.getElementById('bairro').value;
    const localidade = document.getElementById('localidade').value;
    const uf = document.getElementById('uf').value;
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