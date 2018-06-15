Laravel com TDD :D

Refatorando:

Pensando que eu tenho um método no controller (index) que retorna algumas opções de listagem de objetos por meio de queries que são executadas de acordo com estruturas condicionais...

1 - Posso refatorar o método no próprio controller, deixando o index só para chamar o método e atribuí-lo a uma variável, passando o parâmetro requerido, que no caso seria o filtro (channel, ou user, por exemplo). E fazer um segundo método só com as queries e condições, retornando essa o objeto da query. 
No método index então eu chamaria $obj = $this->metodoQuery($parametro)

2 - Dado que o número de tipos de consultas pode sempre aumentar, uma opção é fazer uma classe só pra queries (uma classe só para trabalhar os filtros de threads), a própria query vai virar um objeto.
No método index então eu chamaria $obj = (new NovaClasseQuery)->get()

3 - Crio uma nova classe de filtro, com métodos estáticos. Mas aí eu teria que incluir essa classe também como parâmetro e chamá-la nesse controller, injetando a instância desse filtro no controller desse index.
No método index então eu chamaria $obj = ClasseFiltro::metodoestaticofiltro($filters)->get().

4 - Complementando a solução anterior, eu faço um contructor para a nova classe que filtra, passando o request, e faço outra função que verifica se tem usuário. O controller chama o método filter e faz uso dos parâmetros passados ($filter), que está declarado no Model.

5 - Construir um model para a classe de filtro também. 


ReplyCount se tornou um atributo do array/json de thread.

