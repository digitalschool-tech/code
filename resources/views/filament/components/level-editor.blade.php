@php
    $state = $getState();
    
    // Extract and parse data, ensuring we have valid arrays
    $player = [];
    if (!empty($state['player'])) {
        if (is_string($state['player'])) {
            $player = json_decode($state['player'], true) ?: [];
        } else {
            $player = is_array($state['player']) ? $state['player'] : [];
        }
    }
    
    $goal = [];
    if (!empty($state['goal'])) {
        if (is_string($state['goal'])) {
            $goal = json_decode($state['goal'], true) ?: [];
        } else {
            $goal = is_array($state['goal']) ? $state['goal'] : [];
        }
    }
    
    $route = [];
    if (!empty($state['route'])) {
        if (is_string($state['route'])) {
            $route = json_decode($state['route'], true) ?: [];
        } else {
            $route = is_array($state['route']) ? $state['route'] : [];
        }
    }
    
    $blocks = [];
    if (!empty($state['blocks'])) {
        if (is_string($state['blocks'])) {
            $blocks = json_decode($state['blocks'], true) ?: [];
        } else {
            $blocks = is_array($state['blocks']) ? $state['blocks'] : [];
        }
    }
    
    // Debug data for console
    $debugData = json_encode([
        'state' => $state,
        'player' => $player, 
        'goal' => $goal,
        'route' => $route,
        'blocks' => $blocks
    ]);
@endphp

<div
    x-data="{
        selectedTool: 'player',
        player: @json($player),
        goal: @json($goal),
        route: @json($route),
        blocks: @json($blocks),
        
        debug() {
            console.log('Level Editor Data:', {{ $debugData }});
        },
        
        isSelected(x, y, type) {
            if (type === 'player') {
                return this.player && Array.isArray(this.player) && this.player.length === 2 && 
                       parseInt(this.player[0]) === x-1 && parseInt(this.player[1]) === y-1;
            } else if (type === 'goal') {
                return this.goal && Array.isArray(this.goal) && this.goal.length === 2 && 
                       parseInt(this.goal[0]) === x-1 && parseInt(this.goal[1]) === y-1;
            } else if (type === 'route') {
                return this.route && Array.isArray(this.route) && this.route.some(point => 
                    Array.isArray(point) && point.length === 2 && 
                    parseInt(point[0]) === x-1 && parseInt(point[1]) === y-1
                );
            } else if (type === 'blocks') {
                return this.blocks && Array.isArray(this.blocks) && this.blocks.some(point => 
                    Array.isArray(point) && point.length === 2 && 
                    parseInt(point[0]) === x-1 && parseInt(point[1]) === y-1
                );
            }
            return false;
        },
        
        toggleCell(x, y) {
            // Adjust coordinates to 0-based for storage
            const adjustedX = x-1;
            const adjustedY = y-1;
            
            if (this.selectedTool === 'player') {
                this.player = [adjustedX, adjustedY];
            } else if (this.selectedTool === 'goal') {
                this.goal = [adjustedX, adjustedY];
            } else if (this.selectedTool === 'route') {
                if (!Array.isArray(this.route)) {
                    this.route = [];
                }
                const index = this.route.findIndex(point => 
                    Array.isArray(point) && point.length === 2 && 
                    parseInt(point[0]) === adjustedX && parseInt(point[1]) === adjustedY
                );
                if (index === -1) {
                    this.route.push([adjustedX, adjustedY]);
                } else {
                    this.route.splice(index, 1);
                }
            } else if (this.selectedTool === 'blocks') {
                if (!Array.isArray(this.blocks)) {
                    this.blocks = [];
                }
                const index = this.blocks.findIndex(point => 
                    Array.isArray(point) && point.length === 2 && 
                    parseInt(point[0]) === adjustedX && parseInt(point[1]) === adjustedY
                );
                if (index === -1) {
                    this.blocks.push([adjustedX, adjustedY]);
                } else {
                    this.blocks.splice(index, 1);
                }
            }
            
            console.log('Setting state:', {
                player: this.player,
                goal: this.goal,
                route: this.route,
                blocks: this.blocks
            });
            
            this.$wire.set('{{ $getStatePath() }}', {
                player: this.player,
                goal: this.goal,
                route: this.route,
                blocks: this.blocks
            });
        },
        
        init() {
            // Make sure data is initialized properly
            if (!Array.isArray(this.player)) {
                this.player = [];
            }
            
            if (!Array.isArray(this.goal)) {
                this.goal = [];
            }
            
            if (!Array.isArray(this.route)) {
                this.route = [];
            }
            
            if (!Array.isArray(this.blocks)) {
                this.blocks = [];
            }
            
            console.log('Initialized data:');
            console.log('Player:', this.player);
            console.log('Goal:', this.goal);
            console.log('Route:', this.route);
            console.log('Blocks:', this.blocks);
            
            // Log debug data
            this.debug();
        }
    }"
    x-init="init"
    class="space-y-4"
>
    <!-- Tool Selection -->
    <div class="grid grid-cols-1 gap-2">
        <button 
            @click="selectedTool = 'player'" 
            :class="{ 'bg-blue-500 dark:bg-blue-700 text-white border-2 border-blue-500 dark:border-blue-400': selectedTool === 'player', 'bg-gray-700 dark:bg-gray-700 hover:bg-gray-600': selectedTool !== 'player' }"
            class="w-full px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center"
            type="button"
        >
            <x-heroicon-s-user class="w-5 h-5 mr-3" />
            <span>Player</span>
            <span class="ml-auto">
                <span x-show="player && Array.isArray(player) && player.length === 2" 
                      x-text="'[' + (parseInt(player[0])+1) + ',' + (parseInt(player[1])+1) + ']'" 
                      class="text-xs opacity-80"></span>
            </span>
        </button>
        
        <button 
            @click="selectedTool = 'goal'" 
            :class="{ 'bg-green-500 dark:bg-green-700 text-white border-2 border-green-500 dark:border-green-400': selectedTool === 'goal', 'bg-gray-700 dark:bg-gray-700 hover:bg-gray-600': selectedTool !== 'goal' }"
            class="w-full px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center"
            type="button"
        >
            <x-heroicon-s-flag class="w-5 h-5 mr-3" />
            <span>Goal</span>
            <span class="ml-auto">
                <span x-show="goal && Array.isArray(goal) && goal.length === 2" 
                      x-text="'[' + (parseInt(goal[0])+1) + ',' + (parseInt(goal[1])+1) + ']'" 
                      class="text-xs opacity-80"></span>
            </span>
        </button>
        
        <button 
            @click="selectedTool = 'route'" 
            :class="{ 'bg-yellow-500 dark:bg-yellow-700 text-white border-2 border-yellow-500 dark:border-yellow-400': selectedTool === 'route', 'bg-gray-700 dark:bg-gray-700 hover:bg-gray-600': selectedTool !== 'route' }"
            class="w-full px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center"
            type="button"
        >
            <x-heroicon-s-map-pin class="w-5 h-5 mr-3" />
            <span>Route</span>
            <span class="ml-auto">
                <span x-show="route && Array.isArray(route) && route.length > 0" 
                      x-text="route.length + ' points'" 
                      class="text-xs opacity-80"></span>
            </span>
        </button>
        
        <button 
            @click="selectedTool = 'blocks'" 
            :class="{ 'bg-gray-500 dark:bg-gray-600 text-white border-2 border-gray-400': selectedTool === 'blocks', 'bg-gray-700 dark:bg-gray-700 hover:bg-gray-600': selectedTool !== 'blocks' }"
            class="w-full px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center"
            type="button"
        >
            <x-heroicon-s-no-symbol class="w-5 h-5 mr-3" />
            <span>Blocks</span>
            <span class="ml-auto">
                <span x-show="blocks && Array.isArray(blocks) && blocks.length > 0" 
                      x-text="blocks.length + ' blocks'" 
                      class="text-xs opacity-80"></span>
            </span>
        </button>
    </div>

    <!-- Grid Container -->
    <div class="p-4 bg-gray-800 rounded-lg justify-center flex gap-8">
        <div class="grid gap-1 bg-gray-900" style="grid-template-columns: 32px repeat(8, 45px); grid-template-rows: 32px repeat(8, 45px);">
            <!-- Empty top-left corner cell -->
            <div class="col-start-1 row-start-1"></div>
            
            <!-- X-axis labels (top row) -->
            @for ($x = 1; $x <= 8; $x++)
                <div class="col-start-{{ $x + 1 }} row-start-1 flex items-center justify-center text-base font-bold text-white">{{ $x }}</div>
            @endfor
            
            <!-- Y-axis labels (leftmost column) arranged vertically -->
            <div class="col-start-1 row-start-2 row-span-8 flex flex-col">
                @for ($y = 1; $y <= 8; $y++)
                    <div class="h-[45px] flex items-center justify-center text-base font-bold text-white">{{ $y }}</div>
                @endfor
            </div>
            
            <!-- Main Grid Cells -->
            @for ($y = 1; $y <= 8; $y++)
                @for ($x = 1; $x <= 8; $x++)
                    <button
                        type="button"
                        @click="toggleCell({{ $x }}, {{ $y }})"
                        class="col-start-{{ $x + 1 }} row-start-{{ $y + 1 }} w-[45px] h-[45px] transition-all flex items-center justify-center bg-black border border-white rounded-lg"
                        :class="{
                            'bg-blue-800 hover:bg-blue-700 border-blue-400': isSelected({{ $x }}, {{ $y }}, 'player'),
                            'bg-green-800 hover:bg-green-700 border-green-400': isSelected({{ $x }}, {{ $y }}, 'goal'),
                            'bg-yellow-800 hover:bg-yellow-700 border-yellow-400': isSelected({{ $x }}, {{ $y }}, 'route'),
                            'bg-gray-500 hover:bg-gray-400 border-gray-300': isSelected({{ $x }}, {{ $y }}, 'blocks')
                        }"
                    >
                        <template x-if="isSelected({{ $x }}, {{ $y }}, 'player')">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center shadow-md">
                                <x-heroicon-s-user class="w-5 h-5 text-white" />
                            </div>
                        </template>
                        <template x-if="isSelected({{ $x }}, {{ $y }}, 'goal')">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center shadow-md">
                                <x-heroicon-s-flag class="w-5 h-5 text-white" />
                            </div>
                        </template>
                        <template x-if="isSelected({{ $x }}, {{ $y }}, 'route')">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center shadow-md">
                                <x-heroicon-s-map-pin class="w-5 h-5 text-white" />
                            </div>
                        </template>
                        <template x-if="isSelected({{ $x }}, {{ $y }}, 'blocks')">
                            <div class="w-8 h-8 bg-gray-600 rounded-md flex items-center justify-center shadow-md">
                                <x-heroicon-s-no-symbol class="w-5 h-5 text-white" />
                            </div>
                        </template>
                    </button>
                @endfor
            @endfor
        </div>
    <div class="grid grid-cols-4 bg-gray-800 rounded-lg">
        <div class="flex items-center gap-2 justify-center">
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center shadow-sm">
                <x-heroicon-s-user class="w-5 h-5 text-white" />
            </div>
            <span class="text-sm text-gray-300">Player</span>
        </div>
        <div class="flex items-center gap-2 justify-center">
            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center shadow-sm">
                <x-heroicon-s-flag class="w-5 h-5 text-white" />
            </div>
            <span class="text-sm text-gray-300">Goal</span>
        </div>
        <div class="flex items-center gap-2 justify-center">
            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center shadow-sm">
                <x-heroicon-s-map-pin class="w-5 h-5 text-white" />
            </div>
            <span class="text-sm text-gray-300">Route</span>
        </div>
        <div class="flex items-center gap-2 justify-center">
            <div class="w-8 h-8 bg-gray-600 rounded-md flex items-center justify-center shadow-sm">
                <x-heroicon-s-no-symbol class="w-5 h-5 text-white" />
            </div>
            <span class="text-sm text-gray-300">Blocks</span>
        </div>
    </div>
    </div>
</div> 