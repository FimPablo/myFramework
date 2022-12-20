function popUpLoading(mostrar) {
    if (mostrar) {
        let popUp = $('<div></div>');
        popUp.addClass('popUpBackground');
        popUp.attr('id', 'popUpLoading');
        popUp.attr('style', "z-index: 10");
        popUp.append('<div class = "popUp"><div class = "container d-flex justify-content-center" style="color:#fff"><div class="spinner-border" role="status"></div></div></div>');

        $('body').append(popUp);
    } else {
        $('#popUpLoading').remove();
    }
}

function popUp(titulo, conteudo) {
    let popUp = new Tela('popUpResposta');

    popUp.tituloJanela = titulo;
    popUp.conteudoHtml = conteudo;
    popUp.larguraFixa = '40vw';
    popUp.arrastavel = true;

    popUp.renderizarJanela();

}

function inserirDadosNoFormulario(idFormulario, objDados) {
    Object.keys(objDados).forEach((chave) => {
        try {
            let form = $('#' + idFormulario + ' #' + chave);

            let acoes = {
                'text': (form, informacao) => { form.val(informacao) },
                'number': (form, informacao) => { form.val(informacao) },
                'select': (form, informacao) => { form.find('option[value="' + informacao + '"]').attr('selected', true) },
                'textField': (form, informacao) => { form.val(informacao) },
                'hidden': (form, informacao) => { form.val(informacao) }
            };

            acoes[form.attr('type')](form, objDados[chave]);
        } catch (error) {
            console.log('#' + idFormulario + ' #' + chave + ' não encontrado');
        }
    });
}

class Tela {
    id;
    tituloJanela;
    conteudoHtml;
    overflow;
    alturaMaxima;
    tela;
    larguraFixa;

    constructor(id) {
        this.id = id;
        this.tituloJanela = '';
        this.conteudoHtml = '';
        this.overflow = 'hidden';
        this.alturaMaxima = '80vh';
        this.arrastavel = false;
        this.larguraFixa = '';
        this.fundoEscuro = true;
    }

    renderizarJanela() {
        this.destruirJanela();

        let cabecalho = `<div id="${this.id}_head" class="card-header popUpHeadColor"><div class="mt-1 row"><div class="col-10"><h6 style="color: #fff;" id="titulo">${this.tituloJanela}</h6></div><div class="col-2 d-flex justify-content-end" style="color: #fff;"><i class="bi bi-x-square closeButon" onclick="$('#${this.id}').remove()"></i></div></div></div>`;
        let corpo = `<div id="${this.id}_body" class="card-body" style="overflow-y: ${this.overflow};">${this.conteudoHtml}</div>`;

        this.tela = `<div id="${this.id}" class="popUpBackground ${this.fundoEscuro?"fundoEscuro":""}"><div class="card popUp" id="${this.id}_janela" style="max-height: ${this.alturaMaxima};  ${this.larguraFixa = '' ? "" : "width:" + this.larguraFixa}">${cabecalho}${corpo}</div></div>`;

        $('body').append(this.tela);

        if (!this.arrastavel) {
            return;
        }
        this.tornarArrastavel();
    }

    destruirJanela() {
        $(`#${this.id}`).remove();
    }

    tornarArrastavel() {
        let cabecalho = $(`#${this.id}_head`);
        let janela = $(`#${this.id}_janela`);
        let tela = $(`#${this.id}`);

        cabecalho.on('mousedown', () => {
            cabecalho.on('mousemove', () => {
                let positionTop = parseInt(janela.css('top'));
                let positionLeft = parseInt(janela.css('left'));

                let minX = parseInt(tela.css('left')) + (parseInt(janela.css('width')) / 2);
                let minY = parseInt(tela.css('top')) + (parseInt(janela.css('height')) / 2);

                let maxX = parseInt(tela.css('width')) - (parseInt(janela.css('width')) / 2);
                let maxY = parseInt(tela.css('height')) - (parseInt(janela.css('height')) / 2);

                positionTop += event.movementY;
                positionLeft += event.movementX;

                if(positionTop < maxY - 1 && positionTop > minY + 1){
                    janela.css('top', positionTop);
                }

                if(positionLeft < maxX-1 && positionLeft > minX + 1){
                    janela.css('left', positionLeft);
                }
            });
        });

        $(document).on('mouseup', ()=>{
            cabecalho.off('mousemove');
        });
    }
}

class Rota {
    rota;
    dados;

    requisitar() {
        $.ajax({
            type: "POST",
            url: `../app/${this.rota}`,
            data: this.dados,
            success: function (response) {
                this.resposta = response;
            }
        });
        return this.resposta;
    }

    requisitar() {
        let rota = this.rota;
        let dados = this.dados;

        return new Promise(
            (resolve, reject) => {
                $.ajax({
                    ype: "POST",
                    url: `../app/${rota}`,
                    data: dados,
                    success: function (response) {
                        resolve(response);
                    },
                    fail: function (response) {
                        reject(response);
                    }
                });
            }
        )
    }
}

class View extends Tela {
    nomeView;

    constructor(nomeView) {
        super(nomeView);
        this.nomeView = nomeView;
        this.tituloJanela = nomeView;
        this.arrastavel = true;
        this.larguraFixa = '96vw';
    }

    abrirView() {
        this.pomiseBuscarView().then(
            (response) => {
                this.conteudoHtml = response;
                this.renderizarJanela();
            }
        );
    }

    pomiseBuscarView() {
        let nomeView = this.nomeView;

        return new Promise(
            (resolve, reject) => {
                $.ajax({
                    url: nomeView,
                    success: function (response) {
                        resolve(response);
                    }
                });
            }
        )
    }
}