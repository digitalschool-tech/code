@php
    $state = $getState() ?? [];
    
    // Ensure state is an array even if null
    if (!is_array($state)) {
        $state = [];
    }
    
    // Extract and parse data, ensuring we have valid arrays with default empty arrays
    $player = isset($state['player']) ? (is_string($state['player']) ? json_decode($state['player'], true) : $state['player']) : [];
    $goal = isset($state['goal']) ? (is_string($state['goal']) ? json_decode($state['goal'], true) : $state['goal']) : [];
    $route = isset($state['route']) ? (is_string($state['route']) ? json_decode($state['route'], true) : $state['route']) : [];
    $blocks = isset($state['blocks']) ? (is_string($state['blocks']) ? json_decode($state['blocks'], true) : $state['blocks']) : [];
    
    // Ensure all arrays are valid
    $player = is_array($player) ? $player : [];
    $goal = is_array($goal) ? $goal : [];
    $route = is_array($route) ? $route : [];
    $blocks = is_array($blocks) ? $blocks : [];
    
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
        isLocked: false,
        
        // Check if a specific cell has a player or goal
        hasSinglePoint(x, y, collection) {
            if (!Array.isArray(collection) || collection.length !== 2) {
                return false;
            }
            
            // Convert to numbers and zero-index
            const adjX = Number(x) - 1;
            const adjY = Number(y) - 1;
            
            return Number(collection[0]) === adjX && Number(collection[1]) === adjY;
        },
        
        // Check if a cell is in a collection of points (route or blocks)
        hasCollectionPoint(x, y, collection) {
            if (!Array.isArray(collection)) {
                return false;
            }
            
            // Convert to numbers and zero-index
            const adjX = Number(x) - 1;
            const adjY = Number(y) - 1;
            
            // Check if point exists in collection
            return collection.some(point => 
                Array.isArray(point) && 
                point.length === 2 && 
                Number(point[0]) === adjX && 
                Number(point[1]) === adjY
            );
        },
        
        cellClick(x, y) {
            if (this.isLocked) return;
            
            // Lock to prevent double clicks
            this.isLocked = true;
            
            // Convert to proper numbers and zero-index
            const adjX = Number(x) - 1;
            const adjY = Number(y) - 1;
            
            if (!Number.isFinite(adjX) || !Number.isFinite(adjY) || adjX < 0 || adjY < 0 || adjX > 7 || adjY > 7) {
                console.error('Invalid grid coordinates:', x, y);
                this.isLocked = false;
                return;
            }
            
            // Apply proper tool action
            if (this.selectedTool === 'player') {
                this.player = [adjX, adjY];
            } 
            else if (this.selectedTool === 'goal') {
                this.goal = [adjX, adjY];
            } 
            else if (this.selectedTool === 'route') {
                // Ensure route is an array
                if (!Array.isArray(this.route)) {
                    this.route = [];
                }
                
                // Create a new array to ensure reactivity
                let newRoute = [...this.route];
                
                // Find if point exists
                const index = newRoute.findIndex(point => 
                    Array.isArray(point) && 
                    point.length === 2 && 
                    Number(point[0]) === adjX && 
                    Number(point[1]) === adjY
                );
                
                // Toggle point
                if (index === -1) {
                    newRoute.push([adjX, adjY]);
                } else {
                    newRoute.splice(index, 1);
                }
                
                // Replace the whole array to ensure reactivity
                this.route = newRoute;
            } 
            else if (this.selectedTool === 'blocks') {
                // Ensure blocks is an array
                if (!Array.isArray(this.blocks)) {
                    this.blocks = [];
                }
                
                // Create a new array to ensure reactivity
                let newBlocks = [...this.blocks];
                
                // Find if point exists
                const index = newBlocks.findIndex(point => 
                    Array.isArray(point) && 
                    point.length === 2 && 
                    Number(point[0]) === adjX && 
                    Number(point[1]) === adjY
                );
                
                // Toggle point
                if (index === -1) {
                    newBlocks.push([adjX, adjY]);
                } else {
                    newBlocks.splice(index, 1);
                }
                
                // Replace the whole array to ensure reactivity
                this.blocks = newBlocks;
            }
            
            // Prepare data for saving - create clean copies of all data
            const data = {
                player: Array.isArray(this.player) && this.player.length === 2 ? 
                    [Number(this.player[0]), Number(this.player[1])] : [],
                goal: Array.isArray(this.goal) && this.goal.length === 2 ? 
                    [Number(this.goal[0]), Number(this.goal[1])] : [],
                route: Array.isArray(this.route) ? 
                    this.route.map(point => Array.isArray(point) && point.length === 2 ? 
                        [Number(point[0]), Number(point[1])] : point) : [],
                blocks: Array.isArray(this.blocks) ? 
                    this.blocks.map(point => Array.isArray(point) && point.length === 2 ? 
                        [Number(point[0]), Number(point[1])] : point) : []
            };
            
            // Update Livewire state and ensure UI is updated
            this.$nextTick(() => {
                // Send data directly without additional serialization
                this.$wire.set('{{ $getStatePath() }}', data);
                
                // Give extra time for UI to update before unlocking
                setTimeout(() => {
                    this.isLocked = false;
                }, 350);
            });
        },
        
        formatCoordinate(point) {
            if (!Array.isArray(point) || point.length !== 2) return '';
            
            const x = Number.isFinite(Number(point[0])) ? Number(point[0]) + 1 : '?';
            const y = Number.isFinite(Number(point[1])) ? Number(point[1]) + 1 : '?';
            
            return `[${x},${y}]`;
        },
        
        init() {
            // Clean up any invalid data
            this.player = Array.isArray(this.player) && this.player.length === 2 ? 
                [Number(this.player[0]), Number(this.player[1])] : [];
                
            this.goal = Array.isArray(this.goal) && this.goal.length === 2 ? 
                [Number(this.goal[0]), Number(this.goal[1])] : [];
                
            // Create clean arrays with numeric values
            this.route = Array.isArray(this.route) ? 
                this.route.filter(point => Array.isArray(point) && point.length === 2)
                    .map(point => [Number(point[0]), Number(point[1])]) : [];
                    
            this.blocks = Array.isArray(this.blocks) ? 
                this.blocks.filter(point => Array.isArray(point) && point.length === 2)
                    .map(point => [Number(point[0]), Number(point[1])]) : [];
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
                      x-text="formatCoordinate(player)" 
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
                      x-text="formatCoordinate(goal)" 
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
                    <div
                        class="col-start-{{ $x + 1 }} row-start-{{ $y + 1 }} relative w-[45px] h-[45px]"
                        x-data="{
                            gridX: {{ $x }},
                            gridY: {{ $y }}
                        }"
                    >
                        <button
                            type="button"
                            @click.prevent="cellClick(gridX, gridY)"
                            :disabled="isLocked"
                            class="absolute inset-0 w-full h-full transition-all flex items-center justify-center bg-black border border-white rounded-lg"
                            :class="{
                                'bg-blue-800 hover:bg-blue-700 border-blue-400': hasSinglePoint(gridX, gridY, player),
                                'bg-green-800 hover:bg-green-700 border-green-400': hasSinglePoint(gridX, gridY, goal),
                                'bg-yellow-800 hover:bg-yellow-700 border-yellow-400': hasCollectionPoint(gridX, gridY, route),
                                'bg-gray-600 hover:bg-gray-500 border-gray-300': hasCollectionPoint(gridX, gridY, blocks),
                                'opacity-50 cursor-not-allowed': isLocked
                            }"
                        >
                            <div x-show="hasSinglePoint(gridX, gridY, player)" 
                                 class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center shadow-md">
                                <x-heroicon-s-user class="w-5 h-5 text-white" />
                            </div>
                            
                            <div x-show="hasSinglePoint(gridX, gridY, goal)" 
                                 class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center shadow-md">
                                <x-heroicon-s-flag class="w-5 h-5 text-white" />
                            </div>
                            
                            <div x-show="hasCollectionPoint(gridX, gridY, route)" 
                                 class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center shadow-md">
                                <x-heroicon-s-map-pin class="w-5 h-5 text-white" />
                            </div>
                            
                            <div x-show="hasCollectionPoint(gridX, gridY, blocks)" 
                                 class="w-8 h-8 bg-gray-600 rounded-md flex items-center justify-center shadow-md">
                                <x-heroicon-s-no-symbol class="w-5 h-5 text-white" />
                            </div>
                        </button>
                    </div>
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