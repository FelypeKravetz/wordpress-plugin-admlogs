# AdmLogs - Plugin WordPress

O plugin AdmLogs registra informações de acesso ao site no banco de dados do WordPress e fornece um dashboard simples para visualizar esses registros.

## Instalação

1. Faça o download do plugin.
2. Descompacte o arquivo e coloque a pasta resultante em `wp-content/plugins/` no diretório de instalação do WordPress.
3. Ative o plugin através do painel de administração do WordPress.

## Características

- Registra informações de acesso no banco de dados.
- Cria automaticamente uma tabela no banco de dados quando o plugin é ativado.
- Fornece um dashboard simples para visualizar os últimos acessos.

## Uso

Os acessos são registrados automaticamente sempre que uma página do site é acessada. O dashboard pode ser acessado através do menu "AdmLogs" no painel de administração do WordPress.

## Tabela no Banco de Dados

O plugin cria a tabela `wp_admlogs_acessos` no banco de dados para armazenar os registros de acesso.

| Campo           | Tipo       | Descrição                   |
| --------------- | ---------- | --------------------------- |
| id              | mediumint  | ID único do registro         |
| data_hora       | datetime   | Data e hora do acesso       |
| ip              | varchar    | Endereço IP do visitante    |
| pagina_acessada | varchar    | Página acessada no site     |

## Contribuição

Sinta-se à vontade para contribuir, relatar problemas ou sugerir melhorias.

## Licença

Este plugin é distribuído sob a Licença MIT. Consulte o arquivo `LICENSE` para obter mais detalhes.

---

**Autor:** Felype Kravetz
