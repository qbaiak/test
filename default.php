-- default/example.otui importStyle([=[ ExampleLabel2 < Label text: LOL height: 200 width: 50 ]=]) -- default/battle.lua local batTab = addTab("Batt") Panels.AttackSpell(batTab) Panels.AttackItem(batTab) Panels.AttackLeaderTarget(batTab) Panels.LimitFloor(batTab) Panels.AntiPush(batTab) function friendHealer(parent) local panelName = "healAFriend" local ui = setupUI([[ Panel height: 120 margin-top: 2 SmallBotSwitch id: title anchors.left: parent.left anchors.right: parent.right anchors.top: parent.top text-align: center text: Heal a friend BotTextEdit id: spellName anchors.left: parent.left anchors.right: parent.right anchors.top: title.bottom margin-top: 3 BotTextEdit id: friendName anchors.left: parent.left anchors.right: parent.right anchors.top: spellName.bottom margin-top: 3 BotLabel id: manaInfo anchors.left: parent.left anchors.right: parent.right anchors.top: friendName.bottom text-align: center HorizontalScrollBar id: minMana anchors.left: parent.left anchors.right: parent.right anchors.top: manaInfo.bottom margin-top: 2 minimum: 1 maximum: 100 step: 1 BotLabel id: friendHp anchors.left: parent.left anchors.right: parent.right anchors.top: prev.bottom text-align: center HorizontalScrollBar id: minFriendHp anchors.left: parent.left anchors.right: parent.horizontalCenter anchors.top: friendHp.bottom margin-right: 2 margin-top: 2 minimum: 1 maximum: 100 step: 1 HorizontalScrollBar id: maxFriendHp anchors.left: parent.horizontalCenter anchors.right: parent.right anchors.top: prev.top margin-left: 2 minimum: 1 maximum: 100 step: 1 ]], parent) ui:setId(panelName) if not storage[panelName] then storage[panelName] = { minMana = 60, minFriendHp = 40, maxFriendHp = 90, spellName = "exura sio", friendName = "Greek" } end ui.title:setOn(storage[panelName].enabled) ui.title.onClick = function(widget) storage[panelName].enabled = not storage[panelName].enabled widget:setOn(storage[panelName].enabled) end ui.spellName.onTextChange = function(widget, text) storage[panelName].spellName = text end ui.friendName.onTextChange = function(widget, text) storage[panelName].friendName = text end local updateMinManaText = function() ui.manaInfo:setText("Minimum Mana >= " .. storage[panelName].minMana) end local updateFriendHpText = function() ui.friendHp:setText("" .. storage[panelName].minFriendHp .. "% <= hp >= " .. storage[panelName].maxFriendHp .. "%") end ui.minMana.onValueChange = function(scroll, value) storage[panelName].minMana = value updateMinManaText() end ui.minFriendHp.onValueChange = function(scroll, value) storage[panelName].minFriendHp = value updateFriendHpText() end ui.maxFriendHp.onValueChange = function(scroll, value) storage[panelName].maxFriendHp = value updateFriendHpText() end ui.spellName:setText(storage[panelName].spellName) ui.friendName:setText(storage[panelName].friendName) ui.minMana:setValue(storage[panelName].minMana) ui.minFriendHp:setValue(storage[panelName].minFriendHp) ui.maxFriendHp:setValue(storage[panelName].maxFriendHp) macro(200, function() if storage[panelName].enabled and storage[panelName].spellName:len() > 0 and storage[panelName].friendName:len() > 0 and manapercent() > storage[panelName].minMana then for _, spec in ipairs(getSpectators()) do if spec:isPlayer() and spec:getName() == storage[panelName].friendName then if storage[panelName].minFriendHp >= spec:getHealthPercent() and spec:getHealthPercent() <= storage[panelName].maxFriendHp then if saySpell(storage[panelName].spellName .. " \"" .. storage[panelName].friendName, 1000) then delay(500) end end end end end end) end friendHealer(batTab) -- default/cavebot.lua local caveTab = addTab("Cave") local waypoints = Panels.Waypoints(caveTab) local attacking = Panels.Attacking(caveTab) local looting = Panels.Looting(caveTab) addButton("tutorial", "Help & Tutorials", function() g_platform.openUrl("https://github.com/OTCv8/otclientv8_bot") end, caveTab) -- default/hp.lua local healTab = addTab("HP") Panels.Haste(healTab) Panels.ManaShield(healTab) Panels.AntiParalyze(healTab) Panels.Health(healTab) Panels.Health(healTab) Panels.HealthItem(healTab) Panels.HealthItem(healTab) Panels.ManaItem(healTab) Panels.ManaItem(healTab) Panels.Equip(healTab) Panels.Equip(healTab) Panels.Equip(healTab) Panels.Eating(healTab) -- default/main.lua Panels.TradeMessage() Panels.AutoStackItems() addButton("discord", "Discord & Help", function() g_platform.openUrl("https://discord.gg/yhqBE4A") end) addButton("forum", "Forum", function() g_platform.openUrl("https://otland.net/forums/otclient.494/") end) addButton("github", "Documentation", function() g_platform.openUrl("https://github.com/OTCv8/otclientv8_bot") end) addSeparator("sep") -- default/mwall_timer.lua -- Magic wall & Wild growth timer --[[ Timer for magic wall and wild growth Set correctly config, that's all you have to do Author: otclient@otclient.ovh ]]-- -- config local magicWallId = 2129 local magicWallTime = 20000 local wildGrowthId = 2130 local wildGrowthTime = 45000 -- script local activeTimers = {} onAddThing(function(tile, thing) if not thing:isItem() then return end local timer = 0 if thing:getId() == magicWallId then timer = magicWallTime elseif thing:getId() == wildGrowthId then timer = wildGrowthTime else return end local pos = tile:getPosition().x .. "," .. tile:getPosition().y .. "," .. tile:getPosition().z if not activeTimers[pos] or activeTimers[pos] < now then activeTimers[pos] = now + timer end tile:setTimer(activeTimers[pos] - now) end) onRemoveThing(function(tile, thing) if not thing:isItem() then return end if (thing:getId() == magicWallId or thing:getId() == wildGrowthId) and tile:getGround() then local pos = tile:getPosition().x .. "," .. tile:getPosition().y .. "," .. tile:getPosition().z activeTimers[pos] = nil tile:setTimer(0) end end) -- default/npc.lua singlehotkey("f10", "npc buy and sell", function() NPC.say("hi") NPC.say("trade") NPC.buy(3074, 2) -- wand of vortex NPC.sell(3074, 1) NPC.closeTrade() end) -- default/tools.lua local toolsTab = addTab("Tools") macro(1000, "exchange money", function() local containers = getContainers() for i, container in pairs(containers) do for j, item in ipairs(container:getItems()) do if item:isStackable() and (item:getId() == 3035 or item:getId() == 3031) and item:getCount() == 100 then g_game.use(item) return end end end end) macro(1000, "this macro does nothing", "f7", function() end) macro(100, "debug pathfinding", nil, function() for i, tile in ipairs(g_map.getTiles(posz())) do tile:setText("") end local path = findEveryPath(pos(), 20, { ignoreNonPathable = false }) local total = 0 for i, p in pairs(path) do local s = i:split(",") local pos = {x=tonumber(s[1]), y=tonumber(s[2]), z=tonumber(s[3])} local tile = g_map.getTile(pos) if tile then tile:setText(p[2]) end total = total + 1 end end) macro(1000, "speed hack", nil, function() player:setSpeed(1000) end) hotkey("f5", "example hotkey", function() info("Wow, you clicked f5 hotkey") end) singlehotkey("ctrl+f6", "singlehotkey", function() info("Wow, you clicked f6 singlehotkey") usewith(268, player) end) singlehotkey("ctrl+f8", "play alarm", function() playAlarm() end) singlehotkey("ctrl+f9", "stop alarm", function() stopSound() end) local positionLabel = addLabel("positionLabel", "") onPlayerPositionChange(function() positionLabel:setText("Pos: " .. posx() .. "," .. posy() .. "," .. posz()) end) local s = addSwitch("sdSound", "Play sound when using sd", function(widget) storage.sdSound = not storage.sdSound widget:setOn(storage.sdSound) end) s:setOn(storage.sdSound) onUseWith(function(pos, itemId) if storage.sdSound and itemId == 3155 then playSound("/sounds/magnum.ogg") end end) macro(100, "hide useless tiles", "", function() for i, tile in ipairs(g_map.getTiles(posz())) do if not tile:isWalkable(true) then tile:setFill('black') end end end) addLabel("mapinfo", "You can use ctrl + plus and ctrl + minus to zoom in / zoom out map")
