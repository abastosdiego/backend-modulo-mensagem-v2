# supp-mb/supp-mensagem-backend

Esse pacote não funciona de maneira autônoma e deve ser instalado no supp-core/supp-administrativo-backend

****** Instalação **************

Atenção, todo o processo abaixo deve ser feito no supp-core/supp-administrativo-backend

Adicionar no composer.json:

    "repositories": [
		{
			"type": "git",
			"url": "link-do-repositorio-git"
		}
    ]

    "require": [
        ...
        "supp-mb/supp-mensagem-backend": "dev-[nome-branch]"
    ]

Rodar o composer update para instalar a vendor

Registrar as entities adicionando em config/packages/doctrine.yaml

    doctrine:
      orm:
        mappings:
            supp_mb.mensagem_backend:
                is_bundle: false
                type: attribute
                dir: "%kernel.project_dir%/vendor/supp-mb/supp-mensagem-backend/src/Entity"
                prefix: 'SuppMB\MensagemBackend\Entity\'
                alias: SuppMBMensagemBackend

Registrar as rotas adicionando em config/routes/attributes.yaml

    supp_mb.mensagem_backend:
        resource: ../../vendor/supp-mb/supp-mensagem-backend/src/Api/V1/Controller/
        type: attribute

Registrar o bundle adicionando em config/bundles.php

    return [
        ...
        SuppMB\MensagemBackend\MensagemBundle::class => ['all' => true],
    ]

Por fim, realizar o rebuild do docker
