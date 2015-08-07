<?php

use Illuminate\Database\Seeder;

class ProposalsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('proposals')->delete();
        
		DB::table('proposals')->insert(array (
			0 => 
			array (
				'id' => 1,
				'user_id' => 1,
				'client_id' => 1,
				'name' => 'Proposta 1',
				'proposal' => '<div id="lipsum">
<h1>Lorem ipsum suite.</h1>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed suscipit hendrerit consequat. Integer ipsum magna, semper in hendrerit faucibus, hendrerit vel orci. Proin efficitur mi in sapien sagittis, sodales consectetur ante feugiat. Nunc sit amet scelerisque lectus. Nullam hendrerit eu metus a dapibus. Sed lorem ante, finibus quis tortor et, pellentesque mollis dui. Nullam ac lectus a mi feugiat mattis ac vel neque. Sed ac turpis eu ex bibendum fermentum vitae id libero. Ut eget convallis nunc, rhoncus pellentesque ipsum. Curabitur ac aliquam nunc, aliquam porta odio.</p>

<p>Etiam nec ante posuere, mollis ligula eu, imperdiet lacus. Sed quis odio et massa vestibulum viverra vitae id elit. Nam libero ante, vulputate ut arcu ut, pretium fermentum eros. Phasellus sagittis at magna vel feugiat. Aliquam id mollis odio. Phasellus sed eros sit amet eros blandit dignissim. Nam libero magna, lacinia vitae congue sit amet, facilisis eu justo. Morbi efficitur mauris eu justo auctor, a pellentesque lacus tincidunt. Sed auctor dapibus porta. Vivamus quis pharetra ex. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut sit amet tincidunt odio. Phasellus at vestibulum nunc.</p>

<p>Donec in tortor id nisl interdum condimentum at a quam. Etiam ornare porttitor erat, sit amet dignissim lacus ultrices non. Quisque condimentum id orci sit amet posuere. Nullam auctor egestas ipsum ac sodales. Morbi sed luctus felis. In posuere ligula eget nulla interdum, nec viverra massa vestibulum. In non augue id ligula vulputate aliquam. Donec placerat non velit id cursus. Mauris nec velit sed eros eleifend convallis ac vel quam. Aenean dapibus risus vitae ligula vestibulum, eu laoreet erat dignissim.</p>

<p>Etiam massa purus, facilisis nec mollis sed, vestibulum in ex. In malesuada mi at quam placerat, semper vestibulum elit dapibus. Maecenas feugiat sodales nulla eu scelerisque. Vivamus dapibus semper finibus. In id mi purus. Mauris est leo, finibus quis velit at, vestibulum convallis elit. Maecenas vestibulum vitae ipsum in convallis. Maecenas rhoncus malesuada felis vel rutrum.</p>

<p>Morbi pellentesque mi ut pellentesque sollicitudin. Nulla pulvinar lorem non ex semper dignissim. In maximus leo et mauris commodo, ut dapibus arcu bibendum. Sed vulputate aliquet justo egestas pellentesque. Quisque interdum accumsan posuere. Cras nec ex eget risus pretium posuere finibus a nibh. Cras justo justo, hendrerit eget malesuada sed, gravida viverra purus. Quisque id diam tempor, rhoncus orci et, aliquam libero. Vestibulum ligula urna, congue ullamcorper mattis in, hendrerit in nisl. Sed accumsan vestibulum mi, sit amet tincidunt velit feugiat interdum. Curabitur feugiat elit sit amet velit commodo dignissim. Mauris lobortis placerat ultrices. Aenean tincidunt sed quam vel porta.</p>

<p>Ut facilisis lorem sit amet tortor eleifend, non porttitor nibh aliquam. Nam arcu enim, iaculis ut rutrum sit amet, vestibulum nec leo. Vivamus suscipit imperdiet nibh et suscipit. Mauris ex nibh, gravida eget fringilla ultricies, scelerisque in tortor. In rhoncus at ante eget lacinia. Vestibulum eget facilisis diam. Vivamus auctor orci eget rhoncus pretium.</p>

<p>Nullam augue tellus, rhoncus a sollicitudin nec, fermentum vel lacus. Pellentesque pharetra metus vel pulvinar lobortis. Praesent id libero non enim facilisis consequat id vitae ipsum. Etiam interdum enim non tellus vestibulum, sit amet dictum nisl scelerisque. Nulla facilisis velit mauris, ut dapibus diam scelerisque et. In nunc velit, aliquam sed tempor egestas, blandit a elit. Nullam interdum dui velit, vitae luctus diam tincidunt convallis. Fusce sit amet mauris sodales, condimentum velit vitae, facilisis ligula. Nullam sit amet hendrerit lacus, id luctus augue. Vestibulum sit amet porta sapien. Curabitur id ante et massa commodo aliquet. Phasellus posuere sodales arcu, quis viverra tortor dapibus eu. Nullam id vulputate quam. Aenean tempus ligula eu ipsum pulvinar gravida. Donec at elit vitae augue condimentum sagittis nec nec est. Vivamus placerat arcu eget libero vehicula congue.</p>

<p>Sed vulputate mi nulla, suscipit dignissim nulla eleifend in. Integer at magna metus. Nulla iaculis sollicitudin ultrices. Curabitur consequat, est non vulputate sodales, risus quam imperdiet massa, eu scelerisque mi diam quis nisi. Sed magna lacus, porta in sagittis sed, sollicitudin ac tortor. Etiam pellentesque, dui in laoreet pharetra, enim est dictum justo, ac posuere ante purus non ex. Nullam ut fringilla erat, ut mattis est. Aenean ultrices leo elit. Mauris sed tortor suscipit, varius diam at, ultricies mi. Praesent eu enim vel elit sagittis dictum. Etiam sit amet lacus vulputate libero venenatis fermentum et sed elit. Nulla et viverra augue, a euismod quam. Ut interdum orci sed risus cursus, et fringilla augue euismod. Nunc laoreet ante id condimentum cursus. Fusce sit amet pharetra leo, in accumsan nisi. Sed tristique, urna ut consequat sodales, velit massa consectetur tortor, in volutpat mi risus non odio.</p>

<p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras malesuada maximus augue, vel maximus magna dapibus in. Cras ultrices neque et viverra aliquam. Aliquam pellentesque vel leo porttitor tincidunt. Nunc sit amet risus nunc. Quisque luctus ligula eget risus egestas cursus. Aliquam sagittis elit non turpis posuere consequat. In ullamcorper, urna et ultricies ultricies, leo enim dapibus sapien, ut convallis est velit ac odio. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam ex est, suscipit a odio nec, suscipit varius metus.</p>

<p>Phasellus eu urna sollicitudin, fermentum odio sed, dictum leo. Fusce et tortor eleifend, rutrum nisl at, gravida ex. Suspendisse venenatis eget neque sed mattis. Aenean elementum euismod diam, at scelerisque orci egestas eget. Praesent eu gravida nulla. Proin mattis rhoncus tellus ac venenatis. Ut id eleifend urna, non feugiat enim. Praesent ultricies a neque vitae interdum. Donec accumsan enim velit, ut viverra sapien fringilla tempor. Maecenas nunc lorem, malesuada at eros non, sagittis interdum odio. Donec finibus vitae purus in rutrum. Cras euismod purus tellus, at dapibus lectus rhoncus vitae. In maximus vestibulum est vitae tempor. Nullam sit amet volutpat neque, a tincidunt lacus. Cras mattis libero tincidunt nisi bibendum, quis pulvinar nunc mattis. Nullam quis vulputate tortor.</p>
</div>
',
				'status' => 0,
				'created_at' => '2015-07-30 20:13:29',
				'updated_at' => '2015-07-30 20:13:29',
			),
		));
	}

}
