Vagrant.configure("2") do |config|
  servers=[
    {
      :hostname => "node1",
      :box => "bento/ubuntu-18.04",
      :ip => "192.168.56.10",
      :ssh_port => '2200'
    },
    {
      :hostname => "node2",
      :box => "bento/ubuntu-18.04",
      :ip => "192.168.56.11",
      :ssh_port => '2201'
    }

  ]

  servers.each do |machine|

    config.vm.define machine[:hostname] do |node|
      node.vm.box = machine[:box]
      node.vm.hostname = machine[:hostname]
    
      node.vm.network :private_network, ip: machine[:ip]
      node.vm.network "forwarded_port", guest: 22, host: machine[:ssh_port], id: "ssh"

      node.vm.provider :virtualbox do |v|
        v.customize ["modifyvm", :id, "--memory", 512]
        v.customize ["modifyvm", :id, "--name", machine[:hostname]]
      end
    end
  end

end