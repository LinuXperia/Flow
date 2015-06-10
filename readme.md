# Flow

This is my first attempt at creating the lower level code of a
[Flow Based Programming](https://github.com/flowbased/flowbased.org/wiki) Framework for PHP.
The basic idea for this framework was to create components, which are sometimes referred to as nodes,
that have input and output ports. Then the network stream would execute the nodes,
and send data through the ports via connections.

## Network Stream

The network stream is responsible for executing nodes in the proper order, and passing data through the ports.
The network calculates which node is executed next by looking at the connections, and deciding if an preceding output
node or the following node needs to be executed.
