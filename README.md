# voteReward
Plugin aimed at replacing non-functional voting plugins

```YAML
---
API_KEY: {KEY}

command:
  usage: vote # /vote in game
  description: "Allows to have his recompense of vote"

message_has_not_voted:
  enable: true
  mesasge: "§e[§6vote§e] §cYou did not vote !"

message_has_already_voted:
  enable: true
  mesasge: "§e[§6vote§e] §cYou already voted for the server !"

message_player:
  enable: true
  message:  "§e[§6vote§e] §eThank you for voting for the server !"

message_everyone:
  enable: true
  message: "§e[§6vote§e] §6{player}§e voted for the server !"

# items | commands
reward_type: items

# rewards item
rewards_items:
  - "380#1#1#Vote Reward" # id#meta#amount#customName

# rewards commands
rewards_commands:
  - "/feed"
  - "/heal"
...
```
