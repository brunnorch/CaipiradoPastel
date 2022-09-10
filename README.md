#  Caipira do Pastel
 Projeto realizado para gerenciar uma pastelaria de forma intuitiva e rapida de acordo com a necessidade do cliente.

## Caractéristicas
O projeto foi construido em HTML, CSS, PHP, MYSQL, JS e está completamente responsivo, possui niveís de acesso para 3 tipos de cargo (Admin, caixa, garçom).

O objetivo principal é melhorar o gerenciamento do estabelecimento, o dono terá acesso ao seu usuario de ADMINISTRADOR com o controle total do sistema e poderá dar atenção ao seu estoque, caixa e pedidos através do seu celular onde estiver. O usuário CAIXA terá acesso somente ao computador do estabelecimento onde irá controlar as entradas e saídas do caixa e as mesas ativas. Por fim, o usuário GARÇOM terá acesso através do seu celular para retirar os pedidos das mesas no estabelecimento.

 ## Versão 0.1
- Alerta de estoque baixo por grupo;
- Cadastrar produto;
1. Separação por grupo (pasteis, salgados, refrigerantes).
2. Unidade de venda do produto.
3. Estoque minimo para alerta de estoque do produto.
- Controle de estoque;
- Controle de caixa (entrada e saida);
- Adicionar produtos a um carrinho;
- Criar mesa;
- imprimir pedido ou salvar em PDF;
- Relatórios (caixa, saídas, pedidos, produtos, produtos danificados);
- Gráficos (caixa, produtos, produtos danificados);
- Controle de funcionários;

## Niveís de acesso
- Admin;
O administrador tem acesso a todas funcionalidades.

- Caixa;
Não possui acesso a exclusão de produtos do estoque, relatórios, gráficos e funcionários.

- Garçom;
Não possui acesso a cadastro de produtos, estoque, caixa, mesas(excluir, desconto, imprimir, fechar),relatórios, gráficos e funcionários.

![Niveís de acesso](/nivelacesso.png)
