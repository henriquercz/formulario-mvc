/**
 * Arquivo: public/js/app.js
 * Descrição: Interações client-side para validações e UX do projeto Expedições Lumina.
 * Autor: Henrique Rezende
 * Data: 13/11/2025
 * Versão: 1.0.0
 */

document.addEventListener('DOMContentLoaded', function() {
    const formExpedicao = document.querySelector('.form-expedicao');
    const inputVagasTotal = document.getElementById('vagas_total');
    const inputVagasDisponiveis = document.getElementById('vagas_disponiveis');

    if (formExpedicao) {
        formExpedicao.addEventListener('submit', function(e) {
            if (!validarFormulario()) {
                e.preventDefault();
            }
        });
    }

    if (inputVagasTotal && inputVagasDisponiveis) {
        inputVagasTotal.addEventListener('input', validarVagas);
        inputVagasDisponiveis.addEventListener('input', validarVagas);
    }

    function validarFormulario() {
        let valido = true;
        const camposObrigatorios = formExpedicao.querySelectorAll('[required]');

        camposObrigatorios.forEach(function(campo) {
            if (!campo.value.trim()) {
                mostrarErro(campo, 'Este campo é obrigatório');
                valido = false;
            } else {
                limparErro(campo);
            }
        });

        const dataPartida = document.getElementById('data_partida');
        if (dataPartida && dataPartida.value) {
            const dataSelecionada = new Date(dataPartida.value);
            const hoje = new Date();
            hoje.setHours(0, 0, 0, 0);

            if (dataSelecionada < hoje) {
                mostrarErro(dataPartida, 'A data de partida não pode ser anterior a hoje');
                valido = false;
            }
        }

        const duracao = document.getElementById('duracao_dias');
        if (duracao && duracao.value && parseInt(duracao.value) > 365) {
            mostrarErro(duracao, 'Duração máxima permitida é de 365 dias');
            valido = false;
        }

        if (!validarVagas()) {
            valido = false;
        }

        return valido;
    }

    function validarVagas() {
        const total = parseInt(inputVagasTotal.value) || 0;
        const disponiveis = parseInt(inputVagasDisponiveis.value) || 0;

        if (total > 0 && disponiveis > total) {
            mostrarErro(inputVagasDisponiveis, 'Vagas disponíveis não podem exceder o total');
            return false;
        } else {
            limparErro(inputVagasDisponiveis);
            return true;
        }
    }

    function mostrarErro(campo, mensagem) {
        limparErro(campo);
        campo.classList.add('erro');
        
        const msgErro = document.createElement('span');
        msgErro.className = 'msg-erro';
        msgErro.textContent = mensagem;
        
        campo.parentNode.appendChild(msgErro);
    }

    function limparErro(campo) {
        campo.classList.remove('erro');
        const msgExistente = campo.parentNode.querySelector('.msg-erro');
        if (msgExistente) {
            msgExistente.remove();
        }
    }

    const botoesExcluir = document.querySelectorAll('form[onsubmit*="confirm"]');
    botoesExcluir.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const confirmacao = confirm('Tem certeza que deseja excluir esta expedição? Esta ação não pode ser desfeita.');
            if (!confirmacao) {
                e.preventDefault();
            }
        });
    });

    const cartoes = document.querySelectorAll('.cartao-expedicao');
    cartoes.forEach(function(cartao) {
        cartao.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
    });

    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(function(input) {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focado');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focado');
        });
    });
});
